<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
        <?php use_helper('I18N'); ?>
        <?php if ($sf_context->getModuleName() == 'localization') { ?>
            <script type="text/javascript">

                // initialise plugins
                jQuery(function(){
                    jQuery('ul.sf-menu').superfish();
                    jQuery("#add_label_form").validate({
                        rules: {    
                            'add_label[label_name]': {
                                required: true,    
                                maxlength: 45,
                                minlength:2
                            },    
                            'add_label[label_local_language_string]': {
                                required: true,    
                                maxlength: 45,
                                minlength:2
                            }    
                        },    
                        messages: {    
                            'add_label[label_name]': {
                                required: "<?php echo __('label_name_required', null, 'localizationMessages') ?>",
                                minlength: jQuery.format("<?php echo __('label_name_min', null, 'localizationMessages') ?>")
                            },    
                            'add_label[label_local_language_string]': {
                                required: "<?php echo __('target_label_name_required', null, 'localizationMessages') ?>",
                                minlength: jQuery.format("<?php echo __('target_label_name_min', null, 'localizationMessages') ?>")
                            }    
                        }    
                    });
                });

            </script>
<?php } ?>
    </head>
    <body>
    <?php if( $sf_context->getModuleName() == 'localization') {include_partial('header');} ?>
    <?php if ( $sf_context->getModuleName() == 'localization') {include_partial('adminTopMenu');} ?>
    <?php echo $sf_content ?>
    </body>
</html>
