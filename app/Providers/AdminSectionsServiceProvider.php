<?php

namespace App\Providers;

use AdminSection;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;
use SleepingOwl\Admin\Navigation\Page;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
		Category::class => 'App\Admin\Sections\Category',
		Post::class => 'App\Admin\Sections\Post',
		PostCategory::class => 'App\Admin\Sections\PostCategory',
    ];

    /**
     * Register sections.
     *
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
        parent::boot($admin);
		$this->registerNavigation();
	}

	private function registerNavigation()
	{
		\AdminNavigation::setFromArray([
			[
				'title' => 'Блог',
				'icon' => 'fa fa-newspaper-o',
				'priority' => 120,
				'pages' => [
					(new Page(Post::class))->setPriority(0)->setTitle('Посты')->setIcon('fa fa-list'),
					(new Page(PostCategory::class))->setPriority(10)->setTitle('Категории')->setIcon('fa fa-folder'),
				]
			],
			[
				'title' => 'Настройки',
				'icon' => 'fa fa-cog',
				'priority' => 1000,
				'pages' => [
//					[
//						'title' => 'Глобальные настройки',
//						'icon' => 'fa fa-cog',
//						'url' => route('admin.setting'),
//						'priority' => 0,
//					],
					(new Page(Category::class))->setPriority(10)->setTitle('Дерево категорий')->setIcon('fa fa-folder'),
				]
			],
			[
				'title' => 'Выход',
				'icon' => 'fa fa-sign-out',
				'priority' => 10000,
				'url' => url('/logout')
			]
		]);
	}

}
