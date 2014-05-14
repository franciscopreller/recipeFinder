<?php

namespace FP\RecipeFinderBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use FP\RecipeFinderBundle\Service\JsonRecipeCrawler;
use FP\RecipeFinderBundle\Service\CSVItemsParser;
use FP\RecipeFinderBundle\Container\ItemList;
use FP\RecipeFinderBundle\Model\Item;

class RecipeFindCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('recipe:find')
			->setDescription('Pass a csv list of ingredients available and a json list of recipes, get a recipe suggestion.')
			->addOption('fridge', 'f', InputOption::VALUE_REQUIRED, 'A CSV file with all available ingredients.')
			->addOption('recipes', 'r', InputOption::VALUE_REQUIRED, 'A JSON file with all recipes to choose from.')
			->addOption('demo', null, InputOption::VALUE_NONE, 'Run the application with sample data.');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// display welcome message
		$this->displayWelcomeMessage($output);

		$recipe      = null;
		$fridgePath  = $this->getFridgePath($input);
		$recipesPath = $this->getRecipesPath($input);

		if ($fridgePath && $recipesPath) {
			$fridgeData  = file_get_contents($fridgePath);
			$recipesData = file_get_contents($recipesPath);

			// Convert fridge data into an ItemsList
			$parser = new CSVItemsParser($fridgeData);
			$list   = $parser->getItemList(new ItemList());

			// Initialise crawler
			$crawler = new JsonRecipeCrawler($list, $recipesData);
			$recipe  = $crawler->getSuggestedRecipe();
		}

		// Finalise operation
		$this->displayOutputMessage($output, $recipe);
	}

	private function getFridgePath(InputInterface $input)
	{
		$path = ($input->getOption('demo')) ? 'resources/sample-fridge.csv' : $input->getArgument('fridge');

		return (file_exists($path)) ? $path : null;
	}

	private function getRecipesPath(InputInterface $input)
	{
		$path = ($input->getOption('demo')) ? 'resources/sample-recipes.json' : $input->getArgument('recipes');

		return (file_exists($path)) ? $path : null;
	}

	private function displayWelcomeMessage(OutputInterface $output)
	{
		$output->writeln("
------------------------------------------------------------------
Hey, Welcome! Let me fetch that recipe for you in just a second...
------------------------------------------------------------------
		");
	}

	private function displayOutputMessage(OutputInterface $output, $recipe)
	{
		if ($recipe) {
			$output->writeln("Okay. So I looked at what you have and I think you should have '{$recipe->name}'\n");
		} else {
			$output->writeln("You know what... You should probably 'Order Takeout'\n");
		}
	}

}