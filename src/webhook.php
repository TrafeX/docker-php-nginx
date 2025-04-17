<?php
$data = file_get_contents('php://input');

$json_data = json_decode($data,true);
$token = "7rHgjnqiPL8MZ5zZl/cAescPyxmta+LceUOvljnKPP0hNFgDY4yG00ZeKyGLL0WaQS6SCXfhfzxwTqqVaCwEcHjmIg55goxmfqg/4EVVjNB6M459mfvTwTWp5SV8tiS2p2nVtqoV8czjFtsPZjruawdB04t89/1O/w1cDnyilFU=";
file_put_contents('log_line.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);

if(count($json_data['events'])==0){
    return "verify ok";
    exit();
}

if($json_data['events'][0]['type']=="follow" || $json_data['events'][0]['type']=="unfollow"){
    //file_put_contents('log_line.txt', $json_data['events'][0]['type'] . PHP_EOL, FILE_APPEND);
    $profile_name="";
    if($json_data['events'][0]['type']=="follow"){
        $strUrl = "https://api.line.me/v2/bot/profile/".$json_data['events'][0]['source']['userId'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $strUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $arrHeader = array();
        $arrHeader[] = "Content-Type: application/json";
        $arrHeader[] = "Authorization: Bearer " . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        curl_close ($ch);

        $json_profile = json_decode($result,true);
        $profile_name = $json_profile['displayName'];

    }
   

}
if($json_data['events'][0]['type']=="message"){
        // $strUrl = "https://api.line.me/v2/bot/message/reply";

        // $arrHeader = array();
        // $arrHeader[] = "Content-Type: application/json";
        // $arrHeader[] = "Authorization: Bearer " . $token;
    
        // $arrPostData = array();
        // $arrPostData['replyToken'] = $json_data['events'][0]['replyToken'];
        // $arrPostData['messages'][0]['type'] = "text";
        // $arrPostData['messages'][0]['text'] = "test reply message ".$json_data['events'][0]['message']['text'];

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL,$strUrl );
        // curl_setopt($ch, CURLOPT_HEADER, false);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrPostData));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // $result = curl_exec($ch);
        // curl_close ($ch);

        if($json_data['events'][0]['message']['text'] =="ฝากเงิน" ){
            $web_deposit_manual = "https://www.aslsecurities.com/new/media/upload/17448951051.pdf";
            $web_deposit = "https://webtest2.aslsecurities.com/cash_deposit.aspx";
            $web_billpayment_manual = "https://www.aslsecurities.com/new/media/upload/17448952121.pdf";
            $web_deposit_commission = "https://webtest2.aslsecurities.com/cash_deposit.aspx";
            $web_deposit_commission_fee_manual = "https://webtest2.aslsecurities.com/cash_deposit.aspx";
            $web_deposit_slip = "https://www.aslsecurities.com/new/media/upload/17448952121.pdf";
            $web_deposit_slip_manual = "https://www.aslsecurities.com/new/media/upload/17448952121.pdf";
            $flexDataJson = '{
                                "type": "flex",
                                "altText": "Call Eservice",
                                "contents": {
                                "type": "carousel",
                                "contents": [
                                {
  "type": "carousel",
  "contents": [
    {
      "type": "bubble",
      "size": "micro",
      "hero": {
        "type": "image",
        "url": "https://backend-api-chat.aslsecurities.com/public/assets/img/ats_mobile.png",
        "size": "full",
        "aspectMode": "fit",
        "aspectRatio": "320:213"
      },
      "body": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "text",
            "text": "ฝากเงินผ่าน ATS",
            "weight": "bold",
            "size": "sm",
            "wrap": true,
            "align": "center"
          }
        ],
        "spacing": "sm",
        "paddingAll": "13px"
      },
      "footer": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "separator"
          },
          {
            "type": "button",
            "action": {
              "type": "uri",
              "label": "วิธีการ",
              "uri": "'.$web_deposit_manual.'"
            }
          },
          {
            "type": "button",
            "action": {
              "type": "uri",
              "label": "เริ่มฝากเงิน",
              "uri": "'.$web_deposit.'"
            }
          }
        ]
      }
    },
    {
      "type": "bubble",
      "size": "micro",
      "hero": {
        "type": "image",
        "url": "https://backend-api-chat.aslsecurities.com/public/assets/img/mobile-banking.png",
        "size": "full",
        "aspectMode": "fit",
        "aspectRatio": "320:213"
      },
      "body": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "text",
            "text": "ฝากเงินผ่านธนาคาร Bill Payment",
            "weight": "bold",
            "size": "sm",
            "wrap": true,
            "align": "center"
          }
        ],
        "spacing": "sm",
        "paddingAll": "13px"
      },
      "footer": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "separator"
          },
          {
            "type": "button",
            "action": {
              "type": "uri",
              "label": "วิธีการ",
              "uri": "'.$web_billpayment_manual.'"
            }
          },
          {
            "type": "button",
            "action": {
              "type": "uri",
              "label": "แนบสลิป",
              "uri": "'.$web_deposit_slip.'"
            }
          }
        ]
      }
    },
    {
      "type": "bubble",
      "size": "micro",
      "hero": {
        "type": "image",
        "url": "https://backend-api-chat.aslsecurities.com/public/assets/img/insurance-agent.png",
        "size": "full",
        "aspectMode": "fit",
        "aspectRatio": "320:213"
      },
      "body": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "text",
            "text": "ค่าขายหลักทรัพย์",
            "weight": "bold",
            "size": "sm"
          }
        ],
        "spacing": "sm",
        "paddingAll": "13px"
      },
      "footer": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "separator"
          },
          {
            "type": "button",
            "action": {
              "type": "uri",
              "label": "วิธีการ",
              "uri": "'.$web_deposit_commission_fee_manual.'"
            }
          },
          {
            "type": "button",
            "action": {
              "type": "uri",
              "label": "เริ่มฝากเงิน",
              "uri": "'.$web_deposit_commission_fee.'"
            }
          }
        ]
      }
    }
  ]
}
                                ]

                            }';
                            

            $flexDataJsonDeCode = json_decode($flexDataJson,true);


            $strUrl = "https://api.line.me/v2/bot/message/reply";

            $arrHeader = array();
            $arrHeader[] = "Content-Type: application/json";
            $arrHeader[] = "Authorization: Bearer " . $token;

            $arrPostData = array();
            $arrPostData['replyToken'] = $json_data['events'][0]['replyToken'];
         //   $arrPostData['messages'][0]['type'] = "flex";
        //    $arrPostData['messages'][0]['altText'] = "Call Eservice";
            $arrPostData['messages'][0] =  $flexDataJsonDeCode;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$strUrl );
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrPostData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close ($ch);

        }

        if($json_data['events'][0]['message']['text'] =="ฝาก/ถอนเงิน"){
            $flexDataJson ='{
            "type": "flex",
            "altText": "Call Eservice",
            "contents":
            {
              "type": "bubble",
              "body": {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "text",
                    "text": "เลือกบริการที่สนใจได้เลยค่ะ",
                    "weight": "bold",
                    "size": "lg"
                  }
                ]
              },
              "footer": {
                "type": "box",
                "layout": "vertical",
                "spacing": "sm",
                "contents": [
                  {
                    "type": "button",
                    "style": "link",
                    "height": "sm",
                    "action": {
                      "type": "message",
                      "label": "ฝากเงิน",
                      "text": "ฝากเงิน"
                    }
                  },
                  {
                    "type": "button",
                    "style": "link",
                    "height": "sm",
                    "action": {
                      "type": "message",
                      "label": "ถอนเงิน",
                      "text": "ถอนเงิน"
                    }
                  },
                  {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [],
                    "margin": "sm"
                  }
                ],
                "flex": 0
              }
            }
            }';

            $flexDataJsonDeCode = json_decode($flexDataJson,true);


            $strUrl = "https://api.line.me/v2/bot/message/reply";

            $arrHeader = array();
            $arrHeader[] = "Content-Type: application/json";
            $arrHeader[] = "Authorization: Bearer " . $token;

            $arrPostData = array();
            $arrPostData['replyToken'] = $json_data['events'][0]['replyToken'];
            $arrPostData['messages'][0]=  $flexDataJsonDeCode;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$strUrl );
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrPostData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close ($ch);

        }
}

    return "success";
?>