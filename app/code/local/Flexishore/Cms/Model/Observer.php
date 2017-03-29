<?php

/**
 * @author gencyolcu
 * @copyright 2017
 */

/** * Add image field to form * * @param Varien_Event_Observer $observer * * @return void */
class Flexishore_Cms_Model_Observer{
public function prepareForm(Varien_Event_Observer $observer)
{
    $form = $observer->getEvent()->getForm();
 
    $fieldset = $form->addFieldset(
        'image_fieldset',
        array(
             'legend' => 'Image',
             'class' => 'fieldset-wide'
        )
    );
 
    $fieldset->addField('background', 'image', array(
        'name' => 'background',
        'label' => 'Background image',
        'title' => 'Background image'
    ));
 }
 
      
    /** * Save background image * * @param Varien_Event_Observer $observer * * @return void */
    public function savePage(Varien_Event_Observer $observer)
    {
        $model = $observer->getEvent()->getPage();
        $request = $observer->getEvent()->getRequest();
     
        if (isset($_FILES['background']['name']) && $_FILES['background']['name'] != '') {
            $uploader = new Varien_File_Uploader('background');
     
            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
            $uploader->setAllowRenameFiles(false);
            $uploader->setFilesDispersion(false);
     
            // Set media as the upload dir
            $media_path  = Mage::getBaseDir('media') . DS . 'background' . DS;
     
            // Set thumbnail name
            $file_name = 'cms_';
     
            // Upload the image
            $uploader->save($media_path, $file_name . $_FILES['background']['name']);
     
            $data['background'] = 'background' . DS . $file_name . $_FILES['background']['name'];
     
            // Set thumbnail name
            $data['background'] = $data['background'];
            $model->setBackground($data['background']);
        } else {
            $data = $request->getPost();
            if($data['background']['delete'] == 1) {
                $data['background'] = '';
                $model->setBackground($data['background']);
            } else {
                unset($data['background']);
                $model->setBackground(implode($request->getPost('background')));
            }
        }
    }
}
?>