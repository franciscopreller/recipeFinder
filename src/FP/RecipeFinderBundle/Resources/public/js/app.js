'use strict';
var app = angular.module('recipeApp', []);
app.controller('MainController', ['$scope', '$http', function ($scope, $http) {
	$scope.message        = null;
	$scope.recipeFound    = false;
	$scope.contentPartial = "bundles/fprecipefinder/partials/content.html";
	$scope.headerPartial  = "bundles/fprecipefinder/partials/header.html";

	// initialise demo data
	$scope.ingredients = [
		{ name: 'bread', amount: 10, unit: 'slices', useByDate: '25/12/2014' },
		{ name: 'cheese', amount: 10, unit: 'slices', useByDate: '25/12/2014' },
		{ name: 'butter', amount: 250, unit: 'grams', useByDate: '25/12/2014' },
		{ name: 'peanut butter', amount: 250, unit: 'grams', useByDate: '2/12/2014' },
		{ name: 'mixed salad', amount: 500, unit: 'grams', useByDate: '26/06/2014' }
	];
	$scope.recipes = [
		{
			name: 'grilled cheese on toast',
			ingredients: [
				{ item: 'bread', amount: 2, unit: 'slices' },
				{ item: 'cheese', amount: 2, unit: 'slices' }
			]
		},
		{
			name: 'salad sandwich',
			ingredients: [
				{ item: 'bread', amount: 2, unit: 'slices' },
				{ item: 'mixed salad', amount: 200, unit: 'grams' }
			]
		}
	];
	$scope.addIngredient = function() {
		$scope.ingredients.push({name:null,amount:1,unit:null,useByDate:null});
	}
	$scope.addRecipeIngredient = function(recipe) {
		recipe.ingredients.push({item:null,amount:1,unit:null});
	}
	$scope.addRecipe = function() {
		$scope.recipes.push({name:null,ingredients:[{item:null,amount:1,unit:null}]});
	}
	$scope.getSuggestedRecipe = function() {
		$http.post('/suggest-recipe', {
			fridge : getCSVFromIngredients(),
			recipes: getJSONStringFromRecipes()
		}).success(function(response) {
			$scope.message = response.message;
			$scope.recipeFound = response.success;
		});
	}
	$scope.reset = function() {
		$scope.message = null;
		$scope.recipeFound = false;
	}

	function getCSVFromIngredients()
	{
		var output = "";
		angular.forEach($scope.ingredients, function (ingredient) {
			if (ingredient.name && ingredient.amount && ingredient.unit && ingredient.useByDate) {
				output += [ingredient.name, ingredient.amount, ingredient.unit, ingredient.useByDate].join()+"\n";
			}
		});

		return output;
	}

	function getJSONStringFromRecipes()
	{
		var output = [];
		angular.forEach($scope.recipes, function (recipe) {
			if (recipe.name && recipe.ingredients.length) {
				output.push(recipe);
			}
		});

		return angular.toJson(output);
	}

}]);