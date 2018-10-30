<?php
ini_set("allow_url_fopen", 1);
$url = 'localhost:8090/calendar/get_all_meetings_for_user/'.$this->user_data['user']['id'];
// Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

echo $result;

$content_decoded = json_decode($result);
var_dump($content_decoded);



// $obj = json_decode($json, true);
// var_dump($obj);
?>
<div class="flex text-sm text-black pb-3 px-2 sm:px-0 border-b">
    <span>Reservations</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span class="text-primary font-normal">Dashboard</span>
</div>
<div class="py-4">
    <div id="calendar" data-user="<?= $this->user_data['user']['id'] ?>">
    </div>
</div>
<script src="/js/calendar.js"></script>