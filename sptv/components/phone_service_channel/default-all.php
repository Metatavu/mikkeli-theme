<?php
  $paths = $data->paths;
  $defaultTemplatesPath = $paths["defaultTemplates"];

  include "$defaultTemplatesPath/name.php";
  include "$defaultTemplatesPath/description.php";
  include "phone-numbers.php";
?>