<?php

require_once 'fonctions.php';

function sop_twitter_options() {

    if (!current_user_can('manage_options')) {

        wp_die(__('You do not have sufficient permissions to access this page.'));

    }

    ?>



   
         
    
    
    

<?php

    $wp_categories=get_categories();

    //Save settings

    if(isset($_POST['save']))

    {

        $content=1;

        $additionalText=$_POST['additionalText'];

        $additionalTextAt=$_POST['additionalTextAt'];

        $includeLink=1;

        $tag=1;

        $minIntervalBtPost=$_POST['minIntervalBtPost'];

        $minAgePost=$_POST['minAgePost'];

        $maxAgePost=$_POST['maxAgePost'];

        $nbOfPost=$_POST['nbOfPost'];

        $postType=$_POST['postType'];

        $enableLog=$_POST['enableLog'];



        $ListExcludedCategory=array();

        foreach ($wp_categories as $category) {

            if($_POST['category'.$category->term_id])

                $ListExcludedCategory[]=$_POST['category'.$category->term_id];

        }

    //        $enableLog=$_POST['enableLog'];

        



        $dataSave=array(

            "content" => 1,

            "additionalText" => $additionalText,

            "additionalTextAt" => $additionalTextAt,

            "includeLink" => 1,

            "tag" => 1,

            "minIntervalBtPost" => $minIntervalBtPost,

            "minAgePost" => $minAgePost,

            "maxAgePost" => $maxAgePost,

            "nbOfPost" => $nbOfPost,

            "postType" => 1,

            "enableLog" => 1,

            "excludedCategories" => implode(",",$ListExcludedCategory),

        );

        sop_save_twitter_settings($dataSave);

        echo '<div id="message" class="updated below-h2"><p>';

        ___("settings saved succefully");

        echo '</p> </div>';

    }

    

    

    //Save settings

    elseif(isset($_POST['share'])){

        

        sop_wsClient("checkListShareTwitter");
        echo '<div id="message" class="updated below-h2"><p>Publishing was done succefully</p> </div>';

    }
    
    //Save settings

    elseif(isset($_POST['reset'])){

        sop_get_initial_twitter_settings();
        echo '<div id="message" class="updated below-h2"><p>Settings was reset succefully</p> </div>';

    }
    
    
    //Set Sharing State
    elseif(isset($_POST['stateSharing'])){

        $state=$_POST['stateSharing'];
        if($state==="true")
            $stateChecked='checked="checked"';
        else
            $stateChecked='';
        sop_set_sharing_state("twitter",$state);
    }
    
    if(!$data)

    {

        $data=sop_get_twitter_settings();
        
        $state=$data['state'];
        if($state)
            $stateChecked='checked="checked"';
        else
            $stateChecked='';
        
        $content=1;

        $additionalText=$data['additionalText'];

        $additionalTextAt=$data['additionalTextAt'];

        $includeLink=$data['includeLink'];

        $tag=$data['tag'];

        $minIntervalBtPost=$data['minIntervalBtPost'];

        $minAgePost=$data['minAgePost'];

        $maxAgePost=$data['maxAgePost'];

        $nbOfPost=$data['nbOfPost'];

        $postType=$data['postType'];

        $enableLog=$data['enableLog'];

        $category=$_POST['category'];



        $ListExcludedCategory=array();

        foreach ($wp_categories as $category) {

            if(in_array($category->term_id, explode(",",$data['excludedCategories']),1))

                $ListExcludedCategory[]=$category->term_id;

        }

    }

    ?>
<img src="<?php echo plugins_url(); ?>/wp-share-old-post-lite/img/WP-ShareOld_PagesPlugin.png">
<br><a style="text-decoration: none" href="http://www.shareoldpost.com/shop/share-old-post-for-wordpress">
    <img src="<?php echo plugins_url(); ?>/wp-share-old-post-lite/img/Bouton_LiteSOP.png">
</a>

<link rel="stylesheet" href="<?php echo plugins_url(); ?>/wp-share-old-post-lite/css/onoff.css" type="text/css" media="screen">
<script src="<?php echo plugins_url(); ?>/wp-share-old-post-lite/js/manage_counts.js"></script>

<form method="post" name="sop_form_state_sharing">
    <input name="stateSharing" type="hidden" id="stateSharing">
</form>
   <div style="padding: 20px">         
    <div class="settings" style="float: left; width: 230px" >
                <p>
                    <input type="checkbox" <?php echo $stateChecked; ?> onchange="changeStatusSharing(checked)" class="checkalist"  id="1" name="1" />
                              <label class="check" for="1"></label>
                              <label class="info" id="stateFbsharing"><?php ___("share on twitter"); ?></label>
                        </p>

            </div>
       <div style="padding-top: 7px">
            <input type="button" value="<?php echo ___('manage twitter counts'); ?>" class="button button-primary" onClick="open_twitter_manager_window('<?php echo shortClientURL; ?>');">&nbsp;
   </div>
       </div> 
<div style="padding: 20px" >

    

<form method="post">

    <table>
        
        <tr>

            <td align="right">

                <?php ___("additional text"); ?>

            </td>

            <td>&nbsp;</td>

            <td>

                <input type="text" name="additionalText" value="<?php echo $additionalText; ?>">

            </td>

        </tr>

        <tr>

            <td colspan="2" >

                

            </td>

            <td style="padding-bottom: 5px;font-size:12px;height: 17px;vertical-align: top">

                <?php ___("additional text desc"); ?>

            </td>

        </tr>

        

        



        <tr>

            <td align="right">

                <?php ___("additional text at"); ?>

            </td>

            <td>&nbsp;</td>

            <td>

                <select name="additionalTextAt"> 

                    <option <?php if($additionalTextAt==1) echo "selected='selected'" ?> value="1"><?php ___("begining"); ?></option>

                    <option <?php if($additionalTextAt==2) echo "selected='selected'" ?> value="2"><?php ___("end"); ?></option>

                </select>

            </td>

        </tr>

        
        <tr>

            <td align="right">

                <?php ___("minIntervalBtPost"); ?>

            </td>

            <td>&nbsp;</td>

            <td>

                <select name="minIntervalBtPost">
                    <option value="12">12</option>
                </select>

            </td>

        </tr>

        <tr>

            <td colspan="2" >

                

            </td>

            <td style="padding-bottom: 5px;font-size:12px;height: 17px;vertical-align: top">

                <?php ___("minIntervalBtPost desc"); ?><br>
                <span style="color:red">(Only for Premium version)</span>

            </td>

        </tr>

        

        

        <tr>

            <td align="right">

                <?php ___("minAgePost"); ?>

            </td>

            <td>&nbsp;</td>

            <td>

                <input type="text" name="minAgePost" value="<?php echo $minAgePost; ?>">

            </td>

        </tr>

        <tr>

            <td colspan="2" >

                

            </td>

            <td style="padding-bottom: 5px;font-size:12px;height: 17px;vertical-align: top">

                <?php ___("minAgePost desc"); ?>

            </td>

        </tr>

        

        

        

        <tr>

            <td align="right">

                <?php ___("maxAgePost"); ?>

            </td>

            <td>&nbsp;</td>

            <td>

                <input type="text" name="maxAgePost" value="<?php echo $maxAgePost; ?>">

            </td>

        </tr>

        <tr>

            <td colspan="2" >

                

            </td>

            <td style="padding-bottom: 5px;font-size:12px;height: 17px;vertical-align: top">

                <?php ___("maxAgePost desc"); ?>

            </td>

        </tr>

        

        

        <tr>

            <td align="right">

                <?php ___("nbOfPost"); ?>

            </td>

            <td>&nbsp;</td>

            <td>
                
                <select name="nbOfPost">
                    <option value="1">01</option>
                </select>
                
            </td>

        </tr>

        <tr>

            <td colspan="2" >

                

            </td>

            <td style="padding-bottom: 5px;font-size:12px;height: 17px;vertical-align: top">

                <?php ___("nbOfPost desc"); ?>
                <br>
                <span style="color:red">(Only for Premium version)</span>
            </td>

        </tr>

        <tr>

            <td align="right" nowrap="nowrap">

                <?php ___("categories to Omit"); 

                ?>

            </td>

            <td></td>

            <td style="font-size:12px;">

                <?php ___("categories to Omit desc"); ?>

                

            </td>

        </tr>

        <tr>

            <td align="right">

                

            </td>

            <td></td>

            <td >
                <?php 
                sop_print_categoriescheckbox_by_parent_id(0,$ListExcludedCategory);
                ?>
                

            </td>

        </tr>

        

        

        

        

        <tr>

            <td colspan="3">&nbsp;</td>

        </tr>

        <tr>

            <td align="left" colspan="3">

                <input type="submit" value="<?php ___('save settings'); ?>" class="button button-primary"  name="save">&nbsp;

                <input type="submit" value="<?php ___('share now'); ?>" class="button button-primary" id="submit" name="share">&nbsp;

                <input type="submit" value="<?php ___('reset settings'); ?>" class="button button-primary" id="submit" name="reset">&nbsp;
                
                <a style="text-decoration: none" href="http://www.shareoldpost.com/shop/share-old-post-for-wordpress"><input type="button" value="<?php ___('Up to Premium'); ?>" class="button button-primary" style="background: #09B70B !important" id="submit" name="reset">&nbsp;
                </a>
            </td>

        </tr>

    </table>

</form>

</div>

    <?php

}

function sop_save_twitter_settings($data){

    sop_wsClient("savetwitterSetting",$data);
    }



function sop_get_twitter_settings(){

    $a= json_decode(sop_wsClient("gettwitterSetting",array()),1);

    if(!$a)

    {

        return sop_get_initial_twitter_settings();

    }

    return $a;

    }    

function sop_get_initial_twitter_settings(){

    $initialDataSetting=array(

            "content" => 1,

            "additionalText" => '',

            "additionalTextAt" => 1,

            "includeLink" => 1,

            "tag" => '',

            "minIntervalBtPost" => 1,

            "minAgePost" => 0,

            "maxAgePost" => 0,

            "nbOfPost" => 1,

            "postType" => 1,

            "enableLog" => 1,

            "excludedCategories" => '',
            "state"=>"1",

        );

    sop_save_twitter_settings($initialDataSetting);
    return $initialDataSetting;
    }  
?>