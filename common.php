<?php
function array_marital_status() {
  return array(
    "single" => "Single",
    "married" => "Married",
    "widowed" => "Widowed",
    "divorced" => "Divorced",
    "separated" => "Separated",
    "other" => "Other"
  );
}

function array_gender() {
  return array(
    'male' => 'Male',
    'female' => 'Female'
  );
}

function array_role() {
  return array(
    'staff' => 'Staff',
    'post-grad' => 'Post Grad'
  );
}

function validateDateTime($date, $format = 'm/d/Y') {
  $d = DateTime::createFromFormat($format, $date);
  return $d && $d->format($format) === $date;
}

function validateEmail($email) {
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}
?>