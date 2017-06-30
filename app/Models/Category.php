<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Request;

class Category extends Model
{
	use NodeTrait;

	/**
	 * @var array
	 */
	protected $guarded = ['id', 'created_at', 'updated_at'];

	/**
	 * @var array
	 */
	protected $fillable = ['name', 'slug'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function categorizable(): MorphTo
	{
		return $this->morphTo();
	}

	/**
	 * @param $class
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function entries(string $class): MorphToMany
	{
		return $this->morphedByMany($class, 'categorizable', 'categories_relations');
	}

	/**
	 * @return mixed
	 */
	public static function tree(): array
	{
		return static::get()->toTree()->toArray();
	}

	public function setSlugAttribute($slug)
	{
		$slugCollections = $this->getAncestors()->pluck('slug')->toArray();

		if ($slug == '') $slug = str_slug(Request::get('name'), '_');
//		$slug = str_slug(Request::get('name'), '_');
		if ($cat = self::where('slug', $slug)->first()) {
			$idmax = self::max('id') + 1;
			if (isset($this->attributes['id'])) {
				if ($this->attributes['id'] != $cat->id) {
					$slug = $slug . '_' . ++$idmax;
				}
			} else {
				if (self::where('slug', $slug)->count() > 0)
					$slug = $slug . '_' . ++$idmax;
			}
		}

		$slugCollections[] = $slug;
		$newSlug = implode("/", $slugCollections);
		$this->attributes['slug'] = strlen($newSlug) ? $newSlug : $slug;
	}

	public static function boot()
	{
		parent::boot();

//		static::saved(function($category){
//			$slugAncestors = $category->getAncestors()->pluck('slug')->toArray();
//			$slugAncestors[] = $category->slug;
//			$newSlug = implode("/", $slugAncestors);
//			$category->slug = $newSlug;
//			$user->save();
//			\Log::info($category->slug);
//			\Log::info($newSlug);
//			$user->password = 'testpass';
//			$user->avatar = $user->username . '.jpg';
//		});

	}
}
