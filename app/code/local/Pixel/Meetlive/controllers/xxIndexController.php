<?php

class Pixel_Meetlive_IndexController extends Mage_Core_Controller_Front_Action {

    static private $enable = 1;

    public function submitAction() {
        $data = $this->getRequest()->getPost();
        //print_r($data);die;
		$city = ($data['city']=='other') ? $data['other_city'] : $data['city'];
        $meetlive = Mage::getModel('meetlive/meetlive');
        $meetlive->setName($data['name'])
                ->setEmail($data['email'])
                ->setTelephone($data['mobile'])
				->setDay($data['day'])
                ->setNearestCity($city)
                ->setSuitableTime($data['time'])
                ->setPage('meetlive')
                ->setStatus(self::$enable)
                ->setCreatedTime(now())
                ->setUpdateTime(now());
        $errorMessages = $meetlive->validate();
        if (!empty($errorMessages)) {
            foreach ($errorMessages as $errorMessage) {
                Mage::getSingleton('core/session')->addError(Mage::helper('meetlive')->__("%s", $errorMessage));
            }
            $this->_redirectReferer();
            return;
        }

        try {
            $meetlive->save();

            //sending email to admin
            $emailTemplate = Mage::getModel('core/email_template')
                    ->loadDefault('meetlive_email_template');
            //Create an array of variables to assign to template
            $emailTemplateVariables = array();
            $emailTemplateVariables['name'] = $data['name'];
            $emailTemplateVariables['email'] = $data['email'];
            $emailTemplateVariables['day'] = $this->getDay($data['day']);
            $emailTemplateVariables['telephone'] = $data['mobile'];
            $emailTemplateVariables['nearest_city'] = $city;
            $emailTemplateVariables['suitable_time'] = $this->getTime($data['time']);

            $admin_email = Mage::getStoreConfig('trans_email/ident_general/email');
            
            $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
            $emailTemplate->setSenderName('VESTORO Appointments');
            $emailTemplate->setSenderEmail($admin_email);
            $emailTemplate->setTemplateSubject("Meetlive Appointment");
            $emailTemplate->addBcc($admin_email);

            
            $emailTemplate->send($data['email'], $data['name'], $emailTemplateVariables);


            Mage::getSingleton('core/session')->addSuccess(Mage::helper('meetlive')->__("Your appointment has been received, we will contact your within two business days."));
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError(Mage::helper('meetlive')->__("%s", $e->getMessage()));
        }

        $this->_redirectUrl(Mage::getUrl('appointment'));
    }

	public function getDay($key) {
        $curDate = date('Y-m-d');
		$arr = array(
            'day1' => 'Tomorrow + 1 (' . date('m-d-Y', strtotime($curDate . ' +2 day')) . ')',
            'day2' => 'Tomorrow + 2 (' . date('m-d-Y', strtotime($curDate . ' +3 day')) . ')',
            'day3' => 'Tomorrow + 3 (' . date('m-d-Y', strtotime($curDate . ' +4 day')) . ')',
            'day4' => 'Tomorrow + 4 (' . date('m-d-Y', strtotime($curDate . ' +5 day')) . ')',
			'day5' => 'Tomorrow + 5 (' . date('m-d-Y', strtotime($curDate . ' +6 day')) . ')'
        );
		
		
        return (isset($arr[$key])) ? $arr[$key] : '';
    }
	
    public function getTime($key) {
        $arr = array(
            'after_6pm' => 'After 6pm',
            '2_30_6pm' => '2:30 pm - 6 pm',
            '12pm_2_30pm' => '12 pm - 2:30 pm',
            '9am_12pm' => '9 am -12 pm'
        );
        return (isset($arr[$key])) ? $arr[$key] : '';
    }

    /*public function applicationAction() {
        $data = $this->getRequest()->getPost();
        //print_r($data); die;
        $meetlive = Mage::getModel('meetlive/meetlive');
        $meetlive->setName($data['name'])
                ->setEmail($data['email'])
                ->setTelephone($data['telephone'])
                ->setMessage($data['message'])
                ->setPage('trade_partner')
                ->setStatus(self::$enable)
                ->setCreatedTime(now())
                ->setUpdateTime(now());
        $errorMessages = $meetlive->validate();
        if (!empty($errorMessages)) {
            foreach ($errorMessages as $errorMessage) {
                Mage::getSingleton('core/session')->addError(Mage::helper('meetlive')->__("%s", $errorMessage));
            }
            $this->_redirectReferer();
            return;
        }

        try {

            $meetlive->save();
            //print_r($meetlive); die;
            //sending email to admin
            //get from configuration


            $emailTemplate = Mage::getModel('core/email_template')
                    ->loadDefault('meetlive_application_email_template');
            //Create an array of variables to assign to template
            $emailTemplateVariables = array();
            $emailTemplateVariables['name'] = $data['name'];
            $emailTemplateVariables['email'] = $data['email'];
            $emailTemplateVariables['telephone'] = $data['telephone'];
            $emailTemplateVariables['comment'] = $data['message'];

            $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
            $emailTemplate->setSenderName($data['name']);
            $emailTemplate->setSenderEmail($data['email']);
            $emailTemplate->setTemplateSubject("Application Form Query");


            $admin_email = (string) Mage::getStoreConfig('trans_email/ident_general/email');
            $emailTemplate->send($admin_email, $data['name'], $emailTemplateVariables);


            Mage::getSingleton('core/session')->addSuccess(Mage::helper('meetlive')->__("Application form has been submitted!"));
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError(Mage::helper('meetlive')->__("%s", $e->getMessage()));
        }

        $this->_redirectReferer();
    }
    */
}