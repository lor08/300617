<?php
/**
 * Created by PhpStorm.
 * User: szhih
 * Date: 01.03.17
 * Time: 12:26
 */

declare(strict_types=1);
namespace App\Traits;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Categorizable
{
	/**
	 * @return mixed
	 */
	public function categories(): MorphToMany
	{
		return $this->morphToMany(Category::class, 'categorizable', 'categories_relations');
	}
	/**
	 * @return mixed
	 */
	public function categoriesList(): aray
	{
		return $this->categories()
			->lists('name', 'id')
			->toArray();
	}
	/**
	 * @param $categories
	 */
	public function categorize($categories): void
	{
		foreach ($categories as $category) {
			$this->addCategory($category);
		}
	}
	/**
	 * @param $categories
	 */
	public function uncategorize($categories): void
	{
		foreach ($categories as $category) {
			$this->removeCategory($category);
		}
	}
	/**
	 * @param $categories
	 */
	public function recategorize($categories): void
	{
		$this->categories()->sync([]);
		$this->categorize($categories);
	}
	/**
	 * @param Model $category
	 */
	public function addCategory(Model $category): void
	{
		if (!$this->categories->contains($category->getKey())) {
			$this->categories()->attach($category);
		}
	}
	/**
	 * @param Model $category
	 */
	public function removeCategory(Model $category): void
	{
		$this->categories()->detach($category);
	}
}