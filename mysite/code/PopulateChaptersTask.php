<?php

use SilverStripe\Dev\BuildTask;
use DNADesign\Elemental\Models\BaseElement;
use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\Queries\SQLSelect;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Blog\Model\BlogPost;


class PopulateChaptersTask extends BuildTask{
	protected $title = 'Place chapter pages under recruitment landing pages';
	protected $description = '';

	protected $enabled = true;

	private $chaps = array(

		//PHC 
		278 => array(
			'Zeta Tau Alpha',
			'Pi Beta Phi',
			'Kappa Kappa Gamma',
			'Gamma Phi Beta',
			'Delta Zeta',
			'Delta Gamma',
			'Delta Delta Delta',
			'Chi Omega',
			'Alpha Xi Delta',
			'Alpha Phi',
			'Alpha Epsilon Phi',
			'Alpha Delta Pi',
			'Alpha Chi Omega',
			'Kappa Alpha Theta',
		),



		//IFC
		284 => array(
			'Acacia',
			'Alpha Epsilon Pi',
			'Alpha Sigma Phi',
			'Alpha Tau Omega',
			'Beta Theta Pi',
			'Delta Sigma Phi',
			'Delta Tau Delta',
			'Delta Upsilon',
			'Lambda Chi Alpha',
			'Phi Gamma Delta',
			'Phi Kappa Psi',
			'Phi Kappa Theta',
			'Pi Kappa Phi',
			'Sigma Chi',
			'Sigma Phi Epsilon',
			'Sigma Pi',
			'Tau Kappa Epsilon',
			'Zeta Beta Tau'

		),


		//MGC
		282 => array(
			'alpha Kappa Delta Phi International Sorority Inc.',
			'Delta Lambda Phi Social Fraternity',
			'Delta Phi Lambda Sorority Inc.',
			'Gamma Rho Lambda National Sorority',
			'Lambda Theta Nu Sorority Inc.',
			'Lambda Theta Phi Latin Fraternity Inc.',
			'Pi Alpha Phi',
			'Sigma Lambda Beta International Fraternity Inc.',
			'Sigma Lambda Gamma Sorority Inc.'

		),
		//NPHC
		280 => array(
			'Alpha Kappa Alpha Sorority Inc.',
			'Alpha Phi Alpha Fraternity Inc.',
			'Delta Sigma Theta Sorority Inc.',
			'Kappa Alpha Psi Fraternity Inc.',
			'Zeta Phi Beta Sorority Inc.'
		)
	);


	function run($request){

		echo '<ul>';

		foreach($this->chaps as $key => $chapArray){
			sort($chapArray);
			//print_r($key);
			$parent = SiteTree::get()->filter(array('ID' => $key))->First();

			if($parent){

				$pageList = new ArrayList();

				foreach($chapArray as $chap){
					$page = new LandingSubpage();
					$page->Title = $chap;
					$page->ParentID = $key;
					$page->write();
					$pageList->push($page);

					echo '<li>Page <strong>'.$page->Title.'</strong> created under '.$parent->getParent()->Title.'</li>';
				}

				foreach($pageList as $pageListItem){
					$landingPage = $parent->getParent();
					$landingSection = $landingPage->Sections()->filter(array('Title' => 'Chapters'))->First();
					$landingSection->Content = $landingSection->Content.'<p>[expand page="'.$pageListItem->ID.'" title="'.$pageListItem->Title.'"][/expand]</p>';
					$landingSection->write();
				}


			}

		}


	}

}