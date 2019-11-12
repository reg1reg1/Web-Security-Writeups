<?php

//We know for this input x xored with key y we get cookie z (set aside the base64 format and json_decode format
// base64 is for representing non ascii characters, and json_decode is to convert data into string
// once both are strings the playground is only xor
$defaultdata = array( "showpassword"=>"no", "bgcolor"=>"#ffffff");//loaded into an array
//Cookie z
$cookie= "ClVLIh4ASCsCBE8lAxMacFMZV2hdVVotEhhUJQNVAmhSEV4sFxFeaAw";


//We know the key is not changing or else it will be hard/impossiblen to crack
// + repr xor here
// x + y = z
// then y = z + x
// Once we know y we need to get z' for x' where x'=array("showpassword"=>"yes", "bgcolor"=>"#ffffff")
// Then we are through


// to convert to string
echo json_encode($defaultdata);

//encrypt it to obtain the key, we are calculating z + x
function xor_encrypt($in) {
    $key = base64_decode('ClVLIh4ASCsCBE8lAxMacFMZV2hdVVotEhhUJQNVAmhSEV4sFxFeaAw');
    $text = $in; 
    $outText = ''; // initialization of the outtext
    // Iterate through each character
    for($i=0;$i<strlen($text);$i++) {
    $outText .= $text[$i] ^ $key[$i % strlen($key)]; // looks like key us smaller than the message length
    }
    return $outText; //encrypted outtext
}
echo xor_encrypt(json_encode($defaultdata)); // this will print the key qw8Jqw8Jqw8Jqw8Jqw8Jqw8Jqw8Jqw8Jqw8Jqw8Jq

//Fetching the cookie is easy we want the cookie for this modified default data
//We have y , now for a desired input x' as shown below we calculate z' as y+x'=z'
$defaultdata = array( "showpassword"=>"yes", "bgcolor"=>"#ffffff");

function get_cookie($in){
//Made the key equal to cookie length
$key="qw8Jqw8Jqw8Jqw8Jqw8Jqw8Jqw8Jqw8Jqw8Jqw8Jqw8Jqw8Jqw8Jqw8";
$text = $in; 
    $outText = ''; // initialization of the outtext
    // Iterate through each character
    for($i=0;$i<strlen($text);$i++) {
    $outText .= $text[$i] ^ $key[$i % strlen($key)]; // looks like key us smaller than the message length
    }
    return base64_encode($outText);

}
echo "\n\n\n\n";
//Solved
echo get_cookie(json_encode($defaultdata));
