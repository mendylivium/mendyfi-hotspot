<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Traits\RadiusHelper;
use Illuminate\Http\Request;
use App\Models\HotspotProfile;
use App\Models\HotspotVouchers;
use App\Models\VoucherTemplate;
use App\Http\Controllers\Controller;

class VouchersInfo extends Controller
{
    //

    use RadiusHelper;

    public function print()
    {
        // $sessionToken = request()->get('sessionToken') ?? auth()->user()->sessionToken;
        $apiSecret  =   request()->get('secret');
        $batchCode  =   request()->get('batch');
        $vouhcerId  =   request()->get('id');

        $vouchers = HotspotVouchers::query()
        ->leftJoin('hotspot_profiles','hotspot_profiles.id','hotspot_vouchers.hotspot_profile_id')
        ->leftJoin('resellers','resellers.id','hotspot_vouchers.reseller_id')
        ->select(
            '*',
            'hotspot_vouchers.id as prof_id',
            'hotspot_profiles.name as prof_name',
            'hotspot_profiles.description as prof_desc',
            'hotspot_profiles.price as prof_price',
            'hotspot_profiles.uptime_limit as prof_time_limit',
            'hotspot_profiles.data_limit as prof_data_limit',
            'hotspot_profiles.max_download as prof_max_download',
            'hotspot_profiles.max_upload as prof_max_upload',
            'hotspot_profiles.validity as prof_validity',
            'resellers.name as reseller_name',
            'resellers.id as reseller_id',
        )
        ->where('hotspot_vouchers.used_date',null);


        if($batchCode != null) {
            $vouchers = $vouchers->where('hotspot_vouchers.batch_code',$batchCode);
        }

        
        $vouchers = $vouchers->get();

        $result = [];

        foreach($vouchers as $voucher) {
            $result[] = [
                'id'                    =>  $voucher->prof_id,
                'reseller_name'         =>  $voucher->reseller_name,
                'reseller_id'           =>  $voucher->reseller_id,
                'code'                  =>  $voucher->code,
                'password'              =>  $voucher->password,
                'description'           =>  $voucher->prof_desc,
                'profile'               =>  $voucher->prof_name,
                'price'                 =>  number_format($voucher->price,2),
                'time_limit'            =>  $this->convertSeconds($voucher->prof_time_limit),
                'data_limit'            =>  $voucher->prof_data_limit ? "{$this->convertBytes($voucher->prof_data_limit)}" : "Unlimited",
                'speed_max_download'    =>  $voucher->prof_max_download ? "{$this->convertBytes($voucher->prof_max_download)}ps" : "Unlimited",
                'speed_max_upload'      =>  $voucher->prof_max_upload ? "{$this->convertBytes($voucher->prof_max_upload)}ps" : "Unlimited",
                'validity'              =>  $voucher->prof_validity ? $this->convertSeconds($voucher->prof_validity) : null
            ];
        }

        return response()->json($result);
    }

    public function template()
    {
        // $sessionToken = request()->get('sessionToken') ?? auth()->user()->sessionToken;
        if(!auth()->check()) {
            abort(404);
        }

        $user = auth()->user();
        
        $templateId = request()->get('template');
        $batchCode = request()->get('batch');

        $bodyHTML = '';
        $styleHTML = '';

        $templates = VoucherTemplate::query()
        ->where([
            'user_id' => $user->id,
            'id' => $templateId
        ])
        ->first();

        if(!$templates) {
            $styleHTML = <<<'HTML'
        
            body {
                color: #000000;
                background-color: #FFFFFF;
                font-size: 14px;
                font-family: 'Helvetica', arial, sans-serif;
                margin: 0px;
                -webkit-print-color-adjust: exact;
            }

            table.voucher {
                display: inline-block;
                border: 2px solid black;
                margin: 2px;
            }

            @page {
                size: auto;
                margin-left: 7mm;
                margin-right: 3mm;
                margin-top: 9mm;
                margin-bottom: 3mm;
            }

            @media print {
                table {
                    page-break-after: auto
                }

                tr {
                    page-break-inside: avoid;
                    page-break-after: auto
                }

                td {
                    page-break-inside: avoid;
                    page-break-after: auto
                }

                thead {
                    display: table-header-group
                }

                tfoot {
                    display: table-footer-group
                }
            }

            #num {
                float: right;
                display: inline-block;
            }

            .qrc {
                width: 30px;
                height: 30px;
                margin-top: 1px;
            }
       
        HTML;

        $bodyHTML = <<<'HTML'
        <table class="voucher" style=" width: 160px;">
                <tbody>

                    <tr style="background-color: black;">
                        <td style="text-align: left; font-size: 14px; font-weight:bold;color: white;">
                            <span x-text="voucher.profile"></span><span x-text="voucher.id" id="num"></span>
                        </td>
                    </tr>
                    <tr>

                        <td>
                            <table style=" text-align: center; width: 150px;">
                                <tbody>
                                    <tr style="color: black; font-size: 11px;">
                                        <td>
                                            <table style="width:100%;">
                                                <!-- Username = Password    -->
                                                <tr>
                                                <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=75x75&data=' + voucher.code" />
                                                </tr>
                                                <tr>
                                                    <td>VOUCHER CODE</td>
                                                </tr>
                                                <tr style="color: black; font-size: 14px;">
                                                    <td style="width:100%; border: 1px solid black; font-weight:bold;">
                                                        <span x-text="voucher.code"></span>
                                                    </td>
                                                </tr>

                                                <tr x-show="voucher.password">
                                                    <td>PASSWORD</td>
                                                </tr>
                                                <tr  x-show="voucher.password" style="color: black; font-size: 14px;">
                                                    <td style="width:100%; border: 1px solid black; font-weight:bold;">
                                                        <span x-text="voucher.password"></span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2"
                                                        style="border: 1px solid black; font-weight:bold;">
                                                        Price <span x-text="voucher.price"></span></td>
                                                </tr>
                                                <tr x-show="voucher.time_limit">
                                                    <td colspan="2"
                                                        style="border: 1px solid black; font-weight:bold;">
                                                        Time Limit: <span x-text="voucher.time_limit"></span>
                                                    </td>
                                                </tr>
                                                <tr x-show="voucher.validity">
                                                    <td colspan="2"
                                                        style="border: 1px solid black; font-weight:bold;">
                                                        Validity: <span x-text="voucher.validity"></span>
                                                    </td>
                                                </tr>


                                                <!-- /  -->
                                                <!-- Username & Password  -->


                                                <!-- /  -->
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>

                    </tr>

                </tbody>
            </table>
        HTML;
        } else {
            $bodyHTML = $templates->body;
            $styleHTML = $templates->head;
        }


        return view('vouchers.main',[
            'batch'         =>  $batchCode,
            'bodyHTML'    =>  $bodyHTML,
            'styleHTML'     =>  $styleHTML
        ]);
    }

    public function getAllProfiles($apiPublic)
    {
        $dnsUrl = request()->get('dnsUrl') ?? '10.10.10.10';

        $validator = Validator::make([
            'apiPublic' =>  $apiPublic,
        ],[
            'apiPublic' =>  'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'    =>  'error',
                'message'   =>  $validator->messages()->first()
            ]);
        }

        $profiles = HotspotProfile::leftJoin('users','users.id','hotspot_profiles.user_id')
        ->where('users.api_public', $apiPublic)
        ->select(
            'hotspot_profiles.*'
            )
        ->get();

        if($profiles->count() == 0) {
            return response()->json([
                'status'    =>  'error',
                'message'   =>  'No Profiles Available'
            ]);
        }

        $results = [];

        foreach($profiles as $profile) {
            $results[] = [
                'name'          =>  $profile->name,
                'description'   =>  $profile->description,
                'price'         =>  $profile->price,
                'time_limit'    =>  $profile->uptime_limit,
                'data_limit'    =>  $profile->data_limit,
                'validity'      =>  $profile->validity,
                'link'          =>  route('cashless.profile',['publicToken' => $apiPublic, 'profileId' => $profile->id, 'dnsUrl' => $dnsUrl])
            ];
        }

        return response()->json($results);

    }

    public function getResellerProfiles($apiPublic,$resellerId)
    {
        $validator = Validator::make([
            'apiPublic' =>  $apiPublic,
        ],[
            'apiPublic' =>  'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'    =>  'error',
                'message'   =>  $validator->messages()->first()
            ]);
        }

        $profiles = HotspotProfile::leftJoin('users','users.id','hotspot_profiles.uid')
        ->where([
            'users.api_public' => $apiPublic,
            'hotspot_profiles.reseller_id' => $resellerId
            ])
        ->select(
            'hotspot_profiles.*'
            )
        ->get();

        if($profiles->count() == 0) {
            return response()->json([
                'status'    =>  'error',
                'message'   =>  'No Profiles Available'
            ]);
        }

        $results = [];

        foreach($profiles as $profile) {
            $results[] = [
                'name'  =>  $profile->name,
            ];
        }

        return response()->json($results);

    }
}
