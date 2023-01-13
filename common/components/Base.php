<?php

namespace common\components;

use common\models\NewBranch;
use common\models\User;
use yii;
use yii\base\Component;
use common\models\Currency;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use common\models\Tariff;
use common\models\Parcel;
use common\models\BalanceOperation;

class Base extends Component {

    public function init(){
        parent::init();
    }

    public static function getFirstSentence($string) {
        $string = strip_tags($string);
          $sentences = explode(".", $string);
          $label = null;
          if(isset($sentences[0]))
            $label = $sentences[0];
        if(isset($sentences[1]))
            $label .= $sentences[1];
          return $label;
    }

    public static function returnFileUrl($url, $fullBase = false) {
        $url = str_replace('backend', 'frontend', \Yii::$app->request->getBaseUrl().$url);
        if($fullBase == true)
            $url = \Yii::$app->getUrlManager()->createAbsoluteUrl($url);
        return $url;
    }
    

    public static function getSlug($str,$tl='-')
    {
        $non_english = array(
                'ü','Ü',
                'ö','Ö',
                'ğ','Ğ',
                'ı','I',
                'i','İ',
                'ə','Ə',
                'ç','Ç',
                'ş','Ş',
                'c','C',
                'о','О',
                'ы','Ы',
                'е','Е',
                'ё','Ё',
                'я','Я',
                'щ','Щ',
                'ш','Ш',
                'й','Й',
                'ж','Ж',
                'ч','Ч',
                'ю','Ю',
                'ц','Ц',
                'у','У',
                'в','В',
                'и','И',
                'д','Д',
                'т','Т',
                'б','Б',
                'п','П',
                'н','Н',
                'ф','Ф',
                'ь','Ь',
                'ъ','Ъ',
                'з','З',
                'л','Л',
                'к','К',
                'с','С',
                'м','М',
                'р','Р',
                'х','Х',
                'г','Г',
                'а','А',
                'э','Э'
        );
   
        $english   = array(
                'u','U',
                'o','O',
                'g','G',
                'i','I',
                'i','I',
                'a','A',
                'ch','Ch',
                'sh','Sh',
                'c','C',
                'o','O',
                'y','Y',
                'e','E',
                'yo','Yo',
                'ya','Ya',
                'shc','Shc',
                'sh','Sh',
                'j','J',
                'zh','Zh',
                'ch','Ch',
                'yu','Yu',
                'ts','Ts',
                'u','U',
                'v','V',
                'i','I',
                'd','D',
                't','T',
                'b','B',
                'p','P',
                'n','N',
                'f','F',
                '','',
                '','',
                'z','Z',
                'l','L',
                'k','K',
                's','S',
                'm','M',
                'r','R',
                'h','H',
                'g','G',
                'a','A',
                'je','Je'
        );

        $str = str_replace($non_english ,$english ,$str);
   
        $str = preg_replace('/[^0-9a-zA-Z]/', ' ', $str);
        //$str = preg_replace("/(\d+).(\d+).(\d+)/i"," ",$str);
        $str = preg_replace('/\s\s+/', " ",$str);
        $str = str_replace(' ',$tl ,trim($str));
        return strtolower($str);
    }


    public static function getSmsText($str)
    {
        $non_english = array(
                'ü','Ü',
                'ö','Ö',
                'ğ','Ğ',
                'ı','I',
                'i','İ',
                'ə','Ə',
                'ç','Ç',
                'ş','Ş',
                'c','C',
                'о','О',
                'ы','Ы',
                'е','Е',
                'ё','Ё',
                'я','Я',
                'щ','Щ',
                'ш','Ш',
                'й','Й',
                'ж','Ж',
                'ч','Ч',
                'ю','Ю',
                'ц','Ц',
                'у','У',
                'в','В',
                'и','И',
                'д','Д',
                'т','Т',
                'б','Б',
                'п','П',
                'н','Н',
                'ф','Ф',
                'ь','Ь',
                'ъ','Ъ',
                'з','З',
                'л','Л',
                'к','К',
                'с','С',
                'м','М',
                'р','Р',
                'х','Х',
                'г','Г',
                'а','А',
                'э','Э'
        );
   
        $english   = array(
                'u','U',
                'o','O',
                'g','G',
                'i','I',
                'i','I',
                'e','E',
                'ch','Ch',
                'sh','Sh',
                'c','C',
                'o','O',
                'y','Y',
                'e','E',
                'yo','Yo',
                'ya','Ya',
                'shc','Shc',
                'sh','Sh',
                'j','J',
                'zh','Zh',
                'ch','Ch',
                'yu','Yu',
                'ts','Ts',
                'u','U',
                'v','V',
                'i','I',
                'd','D',
                't','T',
                'b','B',
                'p','P',
                'n','N',
                'f','F',
                '','',
                '','',
                'z','Z',
                'l','L',
                'k','K',
                's','S',
                'm','M',
                'r','R',
                'h','H',
                'g','G',
                'a','A',
                'je','Je'
        );

        $str = str_replace($non_english ,$english ,$str);
   
        return $str;
    }



    /**
     *  This function will generate correct user phone number 
     */
    public function getPhone($number) 
    {
        if(empty($number))
            return '';

        $number = htmlspecialchars(strip_tags(trim($number)));

        $number = ltrim(preg_replace("/[^0-9]/","",$number),0);

        return preg_match('/994/', $number) ? $number : '994'.$number;
    }



    // This function will return clean user ip address

    public function getIp()
    {
        return htmlspecialchars(strip_tags(Yii::$app->getRequest()->getUserIP()));
    }

    // This function will return clean string
    public function getCleanString($data) 
    {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    // This function will return timestamp
    public function  getTime($date,$format='d-m-Y')
    {
        if(trim($date) !='') {
            $date = date_parse_from_format($format, $date);
            $timestamp = mktime($date['hour'], $date['minute'], 0, $date['month'], $date['day'], $date['year']);
            return $timestamp;
        } else {
            return null;
        }
    }

    // Download csv

    public function map_colnames($input)
    {
        global $colnames;
        return isset($colnames[$input]) ? $colnames[$input] : $input;
    }

    public function cleanData(&$str)
    {
        if($str == 't') $str = 'TRUE';
        if($str == 'f') $str = 'FALSE';
        if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
            $str = "$str";
        }
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }


    public function arrayToCsvDownload($data, $filename = 'export.csv', $encode = true)
    {
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: text/csv");

        $out = fopen("php://output", 'w');

        $flag = false;
        foreach($data as $row) {

            if($encode) {
                fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));
            }
            if(!$flag) {
              // display field/column names as first row
              $firstline = array_map( array($this,'cleanData'), array_keys($row));
              fputcsv($out, $firstline, ';', '"');
              $flag = true;
            }
            array_walk($row, array($this,'cleanData'));
            fputcsv($out, array_values($row), ';', '"');
        }

        fclose($out);
        exit;
    }



    // CHECK PHONE NUMBER 
    public function checkPhoneNumber($phone)
    {
        $phone = $this->getCleanString($phone);
        $phone    =  preg_replace("/[^0-9]/","",$phone);
        $phone = '994'.substr($phone, 1);
        $operator =  substr($phone,3,2);

        if(in_array($operator, [70,50,55,77,51,66,99,60]) == true) 
        {
            if(!preg_match('/994/',$phone))
            {
                $phone = '994'.substr($phone, 1);
            }
            
            return $phone;

        } else {
            return false;
        }
    }


    // Generate code for sms
    public function generateSmsCode()
    {
        return rand(100000,999999);
    }

    // Generate random string
    public function generateRandomString($length)
    {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return strtoupper($str);
    }


    public function getYoutubeID($url) {
        $pattern =
            '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
        $result = preg_match($pattern, $url, $matches);
        if (false !== $result) {
            return $matches[1];
        }
        return false;
    }

    public function getLangList()
    {
        $cache = Yii::$app->cache;

        if($cache->get('app-lang'))
        {
            $language = $cache->get('app-lang');
        } else {

            $language =  ArrayHelper::map(\common\models\Lang::find()->all(),'name',function($model,$defaultValue){
                return strtolower($model->key);
            });

            $cache->set('app-lang',$language);
        }

        return array_flip($language);
    }

    public static function updateCurrency()
    {
        $date = date('d.m.Y');
        $dataXml = @file_get_contents("http://www.cbar.az/currencies/{$date}.xml");
        $data = simplexml_load_string($dataXml);

        $currency_list = Currency::find()->where(['status' => 1])->all();

        if(count($currency_list)):

            foreach($currency_list as $currency):

                if($currency->title !='AZN'):

                    $cond = !empty($data->ValType[1]) 
                                && !empty($data->ValType[1]->Valute[$currency->api_index]) 
                                && $data->ValType[1]->Valute[$currency->api_index]->Value > 0;

                    if($cond) 
                    {
                        $currency->price = $data->ValType[1]->Valute[$currency->api_index]->Value;
                        $currency->updated_at = time();
                        $currency->save(false);
                    }

                endif;

            endforeach;

        endif;

        $currency_list = Currency::find()->all();
        Yii::$app->cacheFrontend->set('currency_list', $currency_list);
    }   

    // Generate unique code for every parcel according given id
    public function generateParcelCode($parcel_id) 
    {
        return 'IDS'.sprintf("%06d", $parcel_id);
    }

    // Generate unique code for every parcel according given id
    public function generateFlightNumber($airport_code,$flight_id) 
    {
        return $airport_code.sprintf("%06d", $flight_id);
    }

    // Generate unique code for every container according given id
    public function generateContainerCode($flight_id) {
        $container = \backend\models\Container::find()->where(['flight_id' => $flight_id])->orderBy(['id' => SORT_DESC])->one();

        if($container) {
            $num = intval(str_replace('CN', '', $container->container_code)) + 1;
        } else {
            $num = 1;
        }
        
        return 'CN'.sprintf("%0d", $num);
    }

    public function getOrderPrice($order,$country_id = 1) 
    {
        if(empty($order->weight))
            return null;

        $tariff = Tariff::find()
                    ->where(['country_id' => $country_id])
                    ->andWhere('(from_weight <=:weight and to_weight >= :weight) or (from_weight <=:weight and to_weight=0)',[
                        ':weight' => $order->weight
                    ])
                ->one();

        if(count($tariff)) 
        {
            if(!$tariff->to_weight) 
            {
                return $order->weight * $tariff->price;
            } else {
                return $tariff->price;
            }
        } 
    }

    public function getShoppingLimit($user_id = false)
    {
        $amount = 0;

        if(!$user_id)
            $user_id = Yii::$app->user->id;

        // $try_rate_to_usd = Yii::$app->base->convertPrice(1,'TRY','USD'); 
        // $time = strtotime('-1 month');
        $time = strtotime(date('Y-m-01'));
        // $query = Yii::$app->db->createCommand('SELECT (sum(invoice_price)*'.$try_rate_to_usd.' + sum(shipping_price)) AS `full_invoice_price` FROM `parcel` WHERE (`user_id`='.$user_id.') AND ((created_at >= '. $time .' and created_at < warehouse_accepted_at or (warehouse_accepted_at >='.$time.') ) and shipping_price > 0)');
        $query = Yii::$app->db->createCommand('SELECT sum(invoice_price) as invoice_amount ,sum(shipping_price) AS shipping_amount FROM `parcel` WHERE `user_id`='.$user_id.' AND sent_date >= '. $time .' and shipping_price > 0');
        $result = $query->queryOne();
        
        return Yii::$app->base->convertPrice($result['invoice_amount'],'TRY','USD') + $result['shipping_amount']; 
    }


    public function getAccountDebt($account) 
    {
        $debt_sum = 0;

        $currency = 'USD';

        if(count($account->unpaidParcels)) 
        {
            foreach($account->unpaidParcels as $parcel):

                $debt_sum += $parcel->shipping_price;

                if(count($parcel->parcelServices)) {

                    $debt_sum += array_sum( ArrayHelper::getColumn($parcel->parcelServices, 'price') );
                }

                $currency = $parcel->country->currency->title;

            endforeach;
        }

        return $this->getDoublePrice($debt_sum, $currency, true);
    }



    public function getParcelDebt($parcel, $double_price = false,$convert_usd = false)
    {
        $full_amount = 0;

        if($parcel->country==null || $parcel->payed)
        {
            return 0;
        }

        if($parcel->consolidation) 
        {

            $full_amount = $parcel->consolidation->total_price;
            $currency    = $parcel->consolidation->currency->title;

        } else {
            
            $full_amount += $parcel->shipping_price;
            $full_amount += $this->getParcelServicePrice($parcel);

            $currency = $parcel->country->currency->title;
        }

        // $balance_operations = BalanceOperation::findAll(['parcel_id' => $parcel->id,'op_type' => 0,'refund' => 0]);

        // if(count($balance_operations)) {
        //     $paid_amount = array_sum( ArrayHelper::getColumn($balance_operations, 'amount') );
        //     $full_amount -= $this->convertPrice($paid_amount,$parcel->country->currency->title,'USD');
        // }

        if($convert_usd) {
            $full_amount = $this->convertPrice($full_amount, $currency, 'USD');
        }

        if($double_price) {
            $full_amount = $this->getDoublePrice($full_amount, $currency);
        }

        return $full_amount;
    }


    public function getParcelFullAmount($parcel, $double_price = false, $convert_usd = false) 
    {
        $full_amount = 0;

        if($parcel->country==null)
        {
            return 0;
        }

        $full_amount += $parcel->shipping_price;
       
        $full_amount += $this->getParcelServicePrice($parcel);
 
        if($convert_usd) {
            $full_amount = $this->convertPrice($full_amount, $parcel->country->currency->title, 'USD');
        }
        if($double_price) {
            $full_amount = $this->getDoublePrice($full_amount, $parcel->country->currency->title);
        }   

        return $full_amount;
    }


    public function getShippingPrice($parcel, $double_price = false)
    {
        if($double_price) {
            return $this->getDoublePrice($parcel->shipping_price, $parcel->country->currency->title);
        } 

        return $parcel->shipping_price;
    }


    public function getParcelServicePrice($parcel, $double_price = false)
    {   
        $amount = 0;

        if(count($parcel->parcelServices)) 
        {
            $amount += array_sum( ArrayHelper::getColumn($parcel->parcelServices,'price') );
        }

        if($double_price) {
            return $this->getDoublePrice($amount, $parcel->country->currency->title);
        } 

        return $amount;
    }


    // public function getDoublePrice($amount, $currency = 'USD',$convert_usd = false) {

    //     if($convert_usd) {

    //         $sp_currency = $this->getCurrency('USD');

    //         if($currency != 'AZN') 
    //         {
    //             $from_currency = $this->getCurrency($currency);

    //             $amount = $amount * $from_currency->price;
    //         }

    //         $amount_in_usd = bcdiv((float) ( $amount / $sp_currency->price  ), 1,2);

    //         return  $amount_in_usd .'$ ( '.  bcdiv($amount,1,2) .' ₼)';

    //     } else {

    //         if(!$currency)
    //             return 0;

    //         $currency = $this->getCurrency($currency);

    //         // if(!$amount)
    //         //     return 0;

    //         $amount_foreign_currency = bcdiv((float) ($amount), 1,2);
    //         $amount_azn = bcdiv((float) ( $this->convertPrice($amount_foreign_currency,$currency->title)  ), 1,2);

    //         if($currency->title == 'USD') {
    //             return $amount_foreign_currency.' '.$currency->symbol. ' ('. $amount_azn .' ₼)';
    //         } 

    //         return $amount_foreign_currency. $currency->symbol . ' ('. $amount_azn .' ₼)';
    //     }
    // }

    public function getDoublePrice($amount, $currency = 'USD',$convert_usd = false) {

        if($currency == 'AZN') {
            return number_format($amount,2) .' ₼';
        }

        if($convert_usd) {

            $sp_currency = $this->getCurrency('USD');

            if($currency != 'AZN') 
            {
                $from_currency = $this->getCurrency($currency);

                $amount = $amount * $from_currency->price;
            }

            $amount_in_usd = number_format($amount / $sp_currency->price,2);

            return  $amount_in_usd .'$ ( '.  number_format($amount,2) .' ₼)';

        } else {

            if(!$currency)
                return 0;

            $currency = $this->getCurrency($currency);

            // if(!$amount)
            //     return 0;

            $amount_azn = number_format($this->convertPrice($amount,$currency->title),2);

            if($currency->title == 'USD') {
                return number_format($amount,2).' '.$currency->symbol. ' ('. $amount_azn .' ₼)';
            } 

            return number_format($amount,2). $currency->symbol . ' ('. $amount_azn .' ₼)';
        }
    }


    // public function getShippingPrice($parcel) 
    // {
    //     $azn_price = $this->convertPrice($parcel->shipping_price, 'USD');
    //     return '$'.$parcel->shipping_price.' / '.$azn_price.' AZN';
    // }


    // public function getParcelDebt($parcel, $user) 
    // {
    //     $azn_price = $this->convertPrice($parcel->shipping_price, 'USD');
    //     return '$'.$parcel->shipping_price.' / '.$azn_price.' AZN';
    // }

    public function getUserDebt($parcel, $user) 
    {
        $azn_price = $this->convertPrice($parcel->shipping_price, 'USD');
        return '$'.$parcel->shipping_price.' / '.$azn_price.' AZN';
    }

    public function getInvoice($file) 
    {
        if($file->file_type == 'order_invoice') {
            return $file->base_name;
        }

        if( strpos($file->uuid, '/parcels/') !== false) 
        {
            return str_replace('parcels','parcel',$file->uuid);
        }
        return '/uploads/parcel/'.$file->base_name.'/'.$file->uuid.'.'.$file->extension;
    }

    public function convertPrice($amount, $from, $to = 'AZN')
    {
        $from_currency = $this->getCurrency($from);

        if($to != 'AZN') {

            if($from == 'AZN') {

                $to_currency  = $this->getCurrency($to); 
                $amount = $amount / $to_currency->price; 

            } else {

                $to_currency  = $this->getCurrency($to); 

                $azn_amount = $amount * $from_currency->price;

                $amount = $azn_amount / $to_currency->price; 
            }

        } else {
            $amount = $from_currency->price * $amount;
        }

        return bcdiv((float) $amount,1,2);
    }


    public function getCurrency($currency_title = false)
    {
        if(Yii::$app->cacheFrontend->get('currency_list')) {
            $currency_list = Yii::$app->cacheFrontend->get('currency_list');
        } else {
            $currency_list = Currency::find()->all();
            Yii::$app->cacheFrontend->set('currency_list', $currency_list);
        }

        if($currency_title) {

            if(count($currency_list)):

                foreach($currency_list as $currency):

                    if($currency->title === $currency_title):

                        return $currency;
                        break;

                    endif;

                endforeach;

            endif;

        } 

        return $currency_list;

    }

    public function getSiteName($url, $onlyDomainName = false)
    {
        $url_params = parse_url($url);
        
        $domain = isset($url_params['host']) ? $url_params['host'] : $url_params['path'];
        
        if(!empty($url_params['scheme'])) 
        {   
            return !$onlyDomainName ? $url_params['scheme'].'://'.$domain : str_replace('www.','',$domain);
        }

        return false;
    }


    public function calculateVolume($width, $length, $height) {
        return ( $width * $length * $height / 6000 );
    }


    // Get current warehouse country
    public function getCountry()
    {
        $country_id = Yii::$app->user->identity->country_id;
        return !$country_id ? Yii::$app->session->get('country',2) : $country_id;
    }


    public function getUserCommonDebt($user, $double_amount = true) 
    {
        $debt = 0;

        $consolidated_id = [];

        if(count($user->parcels)) { 

            foreach($user->parcels as $key=>$value): 

                if($value->payed)
                    continue;

                if(in_array($value->consolidation_id, $consolidated_id))
                    continue;

                if($value->consolidation!=null)
                {
                    $debt +=  $this->convertPrice( $value->consolidation->total_price, $value->consolidation->currency->title, 'USD' );
                    $consolidated_id[] = $value->consolidation_id;

                } else if($value->shipping_price && !$value->payed) { 
                    $debt += $this->getParcelFullAmount($value, $double_price = false, $convert_usd = true);
                }

            endforeach;

        }

        if($double_amount) {
            return $this->getDoublePrice($debt, 'USD');
        } 

        return $debt;
    }


    // public function arrayToCsvDownload($array, $filename = "export.csv", $delimiter=";") {
    //     // open raw memory as file so no temp files needed, you might run out of memory though
    //     $f = fopen('php://memory', 'w'); 
    //     // loop over the input array
    //     foreach ($array as $line) { 
    //         // generate csv lines from the inner arrays
    //         fputcsv($f, $line, $delimiter); 
    //     }
       
    //     ob_end_clean();
    //     // reset the file pointer to the start of the file
    //     fseek($f, 0);
    //     // tell the browser it's going to be a csv file
    //     header('Content-Type: application/csv');
    //     // tell the browser we want to save it instead of displaying it
    //     header('Content-Disposition: attachment; filename="'.$filename.'";');
    //     // make php send the generated csv lines to the browser
    //     fpassthru($f);
    //     exit;
    // }
	public function getBranchId($user_id){

		$user=User::findOne ($user_id);

		$default_branch = NewBranch::find ()->where(['default'=>true])->one ();

		if($user->new_branch_id==null){
			return $default_branch->id;
		}
		$checkBranch=NewBranch::findOne ($user->new_branch_id);
		if($checkBranch->status==0){
			return $default_branch->id;
		}
		return $user->new_branch_id;
	}

	public function getParentReferralID($user_id){
		$user=User::findOne ($user_id);
		if($user && $user->referral_id!=null){
			return $user->referral_id;
		}
		return false;
	}
}

