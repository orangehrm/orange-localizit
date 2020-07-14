<?php

require_once dirname(__FILE__) . '/../lib/vendor/autoload.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $webDir = sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'web';
    sfConfig::add(array(
      'sf_web_dir'    => $webDir,
      'sf_upload_dir' => $webDir.DIRECTORY_SEPARATOR.'uploads',
      'sf_language_dir' => $webDir.DIRECTORY_SEPARATOR.'language_files',
    ));
    $this->enablePlugins('sfDoctrinePlugin');
  }
}
