<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\DownloadFile;
use App\Models\Download;
use App\Models\EarningLog;
use App\Models\Image;
use App\Models\Transaction;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class videoController extends Controller
{

    public function download($id)
    {


        $Video = Video::findOrFail(decrypt($id));
        $user    = auth()->user();

        // for premium
        if (!$Video->is_free ) {

            $this->premiumDownloadProcess($Video);
        }
        $this->downloadData($Video, $user);
        session()->flash('is_download', 'downloaded');
        return DownloadFile::download($Video);
    }

    //save download data
    protected function downloadData($Video, $user)
    {

        $general = gs();

        if (1!= @$user->id) {
            if ($user) {
                $download = Download::where('Video_id', $Video->id)->where('user_id', $user->id)->first();
                if (!$download) {
                    $download = new Download();
                    $download->user_id = $user->id;
                    $download->cost  += 4;
                    $Video->total_downloads += 1;
                }
            } else {
                $download = new Download();
                $Video->total_downloads += 1;
            }

            $isDownloaded = Download::where('Video_id', $Video->id)->where('user_id', @$user->id)->exists();

            $download->Video_id = $Video->id;
            $download->contributor_id =  0;
            $download->ip = request()->ip();
            $download->premium = $Video->is_free ? Status::DISABLE : Status::ENABLE;


            if (!$isDownloaded) {
                $amount = $Video->price * $general->per_download / 100;



                // $earn                 = new EarningLog();
                // $earn->contributor_id = 0;
                // $earn->image_id       = $Video->id;
                // $earn->amount         = $amount;
                // $earn->earning_date           = Carbon::now()->format('Y-m-d');
                // $earn->save();

                // $transaction               = new Transaction();
                // $transaction->user_id      = $Video->user->id;
                // $transaction->amount       =  $amount;
                // $transaction->post_balance = getAmount($Video->user->balance);
                // $transaction->charge       = 0;
                // $transaction->trx_type     = '+';
                // $transaction->details      = "Earnings from download '$Video->title'";
                // $transaction->trx          = getTrx();
                // $transaction->remark       = 'earning_log';
                // $transaction->save();
            }

            $Video->save();
            $download->save();
        }
    }


    private function premiumDownloadProcess($image)
    {
        $user = auth()->user();
        if (!$user) {
            throw ValidationException::withMessages(['user' => 'لا يمكنك تنزيل الصورة  بدون أي حساب']);
        }
        $alreadyDownload = Download::where('image_id', $image->id)->where('user_id', $user->id)->exists();

        if ($alreadyDownload) {
            return 0;
        }

        if ($user->purchasedPlan && $user->purchasedPlan->expired_at > Carbon::now()->format('Y-m-d')) {

            $this->purchaseProcessByPlan($image, $user);
        } else {

            throw ValidationException::withMessages(['user' => 'لا يمكنك تنزيل الصورة  التي انتهت صلاحيتها']);

            // $this->purchaseProcessByBalance($image, $user);
        }
    }

    private function purchaseProcessByPlan($image, $user)
    {

        $downloads       = Download::where('image_id', $image->id)->where('user_id', $user->id)->where('premium', Status::YES);

        $todayDownload   = Download::whereDate('created_at', Carbon::now())->sum('cost');

        $monthlyDownload = Download::whereMonth('created_at', Carbon::now()->month)->sum('cost');;

        if ($user->purchasedPlan->daily_limit <= ($todayDownload+4)) {
            throw ValidationException::withMessages(['user' => 'لا يمكنك تنزيل الصورة  ، فقد تجاوزت الحد اليومي']);

        }

        if ($user->purchasedPlan->monthly_limit <= ($monthlyDownload+4)) {
            throw ValidationException::withMessages(['user' => 'لا يمكنك تنزيل الصورة   فقد تجاوزت الحد الشهري ']);

        }
    }

    private function purchaseProcessByBalance($image, $user)
    {
        if ($user->balance < $image->price) {
            throw ValidationException::withMessages(['limit_over' => 'You don\'t have sufficient balance']);
        }

        $user->balance -= $image->price;
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $image->price;
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge       = 0;
        $transaction->trx_type     = '-';
        $transaction->details      = "Charge for download - '$image->title'";
        $transaction->trx          = getTrx();
        $transaction->remark       = 'download_charge';
        $transaction->save();

        notify($user, 'PURCHASE_CHARGE', [
            'image_title'   => $image->title,
            'charge_amount' => showAmount($transaction->amount),
            'post_balance'  => showAmount($transaction->post_balance),
            'trx'           => $transaction->trx
        ]);
    }
}
