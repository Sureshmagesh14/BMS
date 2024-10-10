<?php 
return [
    
  'app_title' =>'The Brand Surgeon', 
  'app_title_short' =>'BMS!',
  'delete' =>'Delete Resource?', 
  'delete_confirmation' =>'Are you sure you want to delete the selected resources?',
  'url' => url('/'), // Using the url() helper function
  'footer'=>'The Brand Surgeon',
  'phone'=>'+27',
  'username' => env('SMS_API_USERNAME', 'default_username'),
  'password' => env('SMS_API_PASSWORD', 'default_password'),
  'account'  => env('SMS_API_ACCOUNT', 'default_account'),
];
?>