<?php

namespace App\customclasses;

use App\constants\StatusConstants;
use DB;
use Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Invitations as InvitationsMail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Firebase\JWT;
use digitell\LiveEventsPlatformAPI;
use Digitell\LiveEventsPlatformAPI\Sessions\BrowserAuth\IdentitySessionEntryBuilder;
use App\Models\Clinic;
use Session;
use Imagick;


class MetaInfo
{

	public function __construct(){
        $this->Corefunctions = new \App\customclasses\Corefunctions; 
	}

	public function getTitle($clinicDetails){
        /*** check in table record exist **/
        $seoArray = Clinic::getAccessSeoDetails($clinicDetails);
        if(!empty($seoArray) && !empty($clinicDetails)){  
            $seoArray['ogimage'] =  $this->Corefunctions->getAWSFilePath($seoArray['ogimage']); 
            $seoArray['twittercard'] =  $this->Corefunctions->getAWSFilePath($seoArray['twittercard']);
        }
        if(empty($seoArray)){  
            /*** check and insert into seo table **/
            $seoArray['title'] = $seoArray['ogtitle'] =  'Join Session | '.$clinicDetails['name'].' | BlackBag';
            $description  = 'At Orthopaedic Medicity, easily connect with professionals in real time. Schedule appointments seamlessly for a smooth, user-friendly consultation experience.';
            $seoArray['description'] = $description;
            $seoArray['keywords'] =  'Book and join online sessions effortlessly with Orthopaedic Medicity on BlackBag. Schedule appointments, access expert consultations, and manage your healthcare seamlessly.';
            $seoArray['og_description'] = "Easily connect with professionals in real time. Schedule appointments via our booking system for a seamless, user-friendly consultation experience.";
                
            /*** insert into DB ****/
            $seoDetail = Clinic::addSeoDetils($clinicDetails,$seoArray);
            if(!empty($clinicDetails) ){
                $seoDetails = $this->getOgImage($seoDetail['seoid'],$seoDetail['seokey'],$clinicDetails,url('public/images/og-img.png'),url('public/images/og-img.png'));
            }
            $seoArray['ogimage']=$seoDetails['ogimage'];
            $seoArray['twittercard']=$seoDetails['ogtwitterimage'];
        }   
        return $seoArray;
    }
    
    public function getOgImage($seoid,$seokey,$clinicDetails,$imagepath,$twittercardPath){
        if( !empty( $clinicDetails ) ){
            //check logo if not mandatory
                $teamLogo ='';
                if( $clinicDetails['logo'] != ''  ){
                    $teamLogo  = $this->Corefunctions->getAWSFilePath($clinicDetails['logo']);
                }else{
                    $teamLogo  = url('public/images/default_clinic.png');
                }

            //echo $teamLogo;die;

            //check Both 

            // open Graph Image & Twitter Card
            $ogimage = $this -> createOgImage($seoid,$seokey,$clinicDetails,$teamLogo,$imagepath);
            
            $ogtwitterimage =$this -> createTwitterCard($seoid,$seokey,$clinicDetails,$teamLogo,$twittercardPath);
            return array('ogimage'=>$ogimage,'ogtwitterimage'=>$ogtwitterimage);
        }

    }
    public function createOgImage($seoid,$seokey,$teamDetails,$teamLogo,$imagepath){
    
        $background = new \Imagick($imagepath);
        $overlay = new \Imagick($teamLogo);

        // Get dimensions of background image
        $bgWidth = $background->getImageWidth();
        $bgHeight = $background->getImageHeight();

        // Get dimensions of overlay image
        $overlayWidth = $overlay->getImageWidth();
        $overlayHeight = $overlay->getImageHeight();

        // Calculate the position to place the overlay image at the center
        $overlayX = ($bgWidth - $overlayWidth) / 2;
        $overlayY = ($bgHeight - $overlayHeight) / 2;

        // Composite the overlay image onto the background image at the calculated position
        $background->compositeImage($overlay, \Imagick::COMPOSITE_DEFAULT, $overlayX, $overlayY);
        $outputPath ='public/images/generateimg.png';
        $crppath = $this->Corefunctions->getMyPathForAWS($seoid,$seokey,'png','uploads/ogimages');
        // Output the final image or save to a file
        if ($outputPath) {
            $background->writeImage($outputPath);
            $this->Corefunctions->uploadDocumenttoAWS1( $crppath, file_get_contents(  $outputPath  ) );
            Clinic::updateSeoDetils($seokey,'ogimage',$crppath);
            $ogimage = $this->Corefunctions->getAWSFilePath($crppath);
            //echo $ogimage;die;
            return $ogimage;
        } else {
            header('Content-Type: image/' . $background->getImageFormat());
            //echo $background;
        }
    }
    public function createTwitterCard($seoid,$seokey,$teamDetails,$teamLogo,$imagepath){
        $background = new \Imagick($imagepath);
        $overlay = new \Imagick($teamLogo);

        // Get dimensions of background image
        $bgWidth = $background->getImageWidth();
        $bgHeight = $background->getImageHeight();

        // Get dimensions of overlay image
        $overlayWidth = $overlay->getImageWidth();
        $overlayHeight = $overlay->getImageHeight();

        // Calculate the position to place the overlay image at the center
        $overlayX = ($bgWidth - $overlayWidth) / 2;
        $overlayY = ($bgHeight - $overlayHeight) / 2;

        // Composite the overlay image onto the background image at the calculated position
        $background->compositeImage($overlay, \Imagick::COMPOSITE_DEFAULT, $overlayX, $overlayY);
        $outputPath ='public/images/generatetwimg.png';
        $crppath = $this->Corefunctions->getMyPathForAWS($seoid,$seokey,'png','uploads/twitterimages');
        // Output the final image or save to a file
        if ($outputPath) {
            $background->writeImage($outputPath);
            $this->Corefunctions->uploadDocumenttoAWS1( $crppath, file_get_contents( $outputPath  ) );
            Clinic::updateSeoDetils($seokey,'twittercard',$crppath);
            $ogimage = $this->Corefunctions->getAWSFilePath($crppath);
            return $ogimage;
        } else {
            header('Content-Type: image/' . $background->getImageFormat());
            //echo $background;
        }
    }
}