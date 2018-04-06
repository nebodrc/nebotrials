<?php

namespace App\Http\Controllers;

use App\Trial;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
//require 'vendor/autoload.php';

use Carbon\Carbon;
use Aws\Ec2\Ec2Client;

class TrialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('trials.index');
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function launch(Request $request){

        try{

            $emt = $request->email;
            $valid = Trial::where('email',$emt)->get();;
            if($valid->isEmpty()){
               	
         
                $awsAccessKeyId= 'AKIAJBM6QL3KRUM5YIFA';
                $awsSecretKey= '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';
                $keySecret = array('credentials' => array(
                        'key'    => $awsAccessKeyId,
                        'secret' => $awsSecretKey,), 
                        'region' => 'us-east-2', 
                        'version' => 'latest');
               
             
                $ec2Client =  Ec2Client::factory($keySecret);
                switch ($request->solution) {
                    case 'crm':
                        
                        $command=base64_encode('#!/bin/bash
                        var2=$(curl http://169.254.169.254/latest/meta-data/public-ipv4)
                        sudo sed -i s/18.218.176.229/$var2/g /var/www/html/crm/config.inc.php
                        ');
                        $image='ami-caf5c0af';

                        break;
                    case 'hrm':

                        $command='';
                        $image='ami-82e6d3e7';

                        break;
                    case 'elearning':
                        
                        $command=base64_encode('#!/bin/bash
                        var2=$(curl http://169.254.169.254/latest/meta-data/public-ipv4)
                        sudo sed -i s/18.219.69.246/$var2/g /var/www/html/moodle/config.php
                        ');
                        $image='ami-cbf4c1ae';

                        break;
                    
                    default:
                        # code...
                        return view('trial.index');
                        break;
                }

                $keyPairName = 'my-keypair22';
                $val = 
                $valmood = 
                $result2 = $ec2Client->runInstances(array(
                'Name'  => 'nebo',
                'ImageId'        => $image,
                //'ImageId'        => 'ami-cbf4c1ae', //elearning
                'MinCount'       => 1,
                'MaxCount'       => 1,
                'InstanceType'   => 't2.micro',
                'KeyName'        => $keyPairName,
                'UserData'       => $command,
                'SecurityGroups' => array('launch-wizard-1'),
                ));


               
                $arr = $result2->toArray();

                $instanceId = $arr['Instances'][0]['InstanceId'];

                $ec2Client->waitUntil('InstanceRunning', ['InstanceIds' => array($instanceId)]);

                $result3 = $ec2Client->describeInstances(array(
                    'InstanceIds' => array($instanceId),));

                $arr = $result3->toArray(); 
                
                $pip = $arr['Reservations'][0]['Instances'][0]['PublicIpAddress']; 
                //$urlarray['url'] = $pip.'/moodle';
                //$url= 'http://'.$pip.'/moodle';
                
                switch ($request->solution) {
                    case 'crm':
                        
                        $url='http://'.$pip.'/crm/';
                        $credentials='Usuario = admin Password = admin';

                        break;
                    case 'hrm':

                        $url='http://'.$pip.'/hrm/';
                        $credentials='Usuario = admin Password = admin';

                        break;
                    case 'elearning':
                        
                        $url='http://'.$pip.'/moodle/';
                        $credentials='Usuario = admin Password = Nebo2018.';

                        break;
                    
                    default:
                        # code...
                        return view('trial.index');
                        break;
                }

                $date_now = Carbon::now();
                $exp_date = $date_now->addDays(15);
                $trialreq =[
                    'email'         => $request->email,
                    'name'          => $request->name,
                    'last_name'     => $request->last_name,
                    'company'       => $request->company,
                    'job_position'  => $request->job_position,
                    'solution'      => $request->solution,
                    'phone'         => $request->phone,
                    'url'           => $url,
                    'instance'      => $instanceId,
                    'created_at'    => $date_now,
                    'exp_date'      => $exp_date,
                  ];

                $save = Trial::insert($trialreq);
                if($save){
                    $urlarray['url'] = $url;
                    $urlarray['cred'] =$credentials;//dd($urlarray);
                return view('trials.ready', $urlarray);
            }

           }else {

           	return view ('trials.existent');
           }


        }catch (Exception $e){ 

            echo 'Exception ', $e->getMessage(), "\n";

        }
}

	


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trial  $trial
     * @return \Illuminate\Http\Response
     */
    public function show(Trial $trial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trial  $trial
     * @return \Illuminate\Http\Response
     */
    public function edit(Trial $trial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trial  $trial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trial $trial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trial  $trial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trial $trial)
    {
        //
    }
}
