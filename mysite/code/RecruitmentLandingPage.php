<?php

class RecruitmentLandingPage extends LandingPage {

	public function getCMSFields(){
		$fields = parent::getCMSFields();

		$fields->removeByName('LayoutType');

		$fields->removeByName('HeaderLogo');
		$fields->removeByName('ShowBreadcrumbs');
		$fields->removeByName('SecondaryImage');
		$fields->removeByName('FacebookLink');
		$fields->removeByName('InstagramLink');
		$fields->removeByName('TwitterLink');

		$fields->renameField('HeaderImage', 'Header Image (1600 x 800 preferred)');
		$fields->renameField('HeaderImageAltText', 'Header Image Descriptive Text (if above image has text in it)');
		return $fields;
	}


}
