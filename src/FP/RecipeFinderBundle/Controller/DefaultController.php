<?php

namespace FP\RecipeFinderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use FP\RecipeFinderBundle\Service\CSVItemsParser;
use FP\RecipeFinderBundle\Service\JsonRecipeCrawler;
use FP\RecipeFinderBundle\Container\ItemList;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/suggest-recipe")
     * @Method({"POST"})
     */
    public function getSuggestedRecipeAction()
    {
    	$params = (object) $this->getRequestJson();

    	// Convert fridge data into an ItemsList
		$parser = new CSVItemsParser($params->fridge);
		$list   = $parser->getItemList(new ItemList());

		// Initialise crawler
		$crawler = new JsonRecipeCrawler($list, $params->recipes);
		$recipe  = $crawler->getSuggestedRecipe();

		$message = ($recipe)
			? "So I looked at what you have and I think you should have '{$recipe->name}'"
			: "You know what... You should probably 'Order Takeout'";

    	return new JsonResponse(array(
    		'message' => $message,
    		'success' => ($recipe !== null)
    	), 200);
    }

    protected function getRequestJson(){
	    $params = null;
	    $content = $this->get("request")->getContent();
	    if (!empty($content))
	    {
	        $params = json_decode($content, true);
	    }
	    return $params;
	}
}
