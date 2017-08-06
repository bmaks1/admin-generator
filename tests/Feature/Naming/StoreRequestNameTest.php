<?php

namespace Brackets\AdminGenerator\Tests\Feature\Naming;

use Brackets\AdminGenerator\Tests\TestCase;
use File;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StoreRequestNameTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function store_request_generation_should_generate_a_store_request_name(){
        $filePath = base_path('App/Http/Requests/Admin/Category/StoreCategory.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:request:store', [
            'table_name' => 'categories'
        ]);

        $this->assertFileExists($filePath);
        $this->assertStringStartsWith('<?php namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;
use Gate;

class StoreCategory extends FormRequest', File::get($filePath));
    }

    /** @test */
    function testing_correct_name_for_custom_model_name(){
        $filePath = base_path('App/Http/Requests/Admin/Cat/StoreCat.php');

        $this->assertFileNotExists($filePath);

        $this->artisan('admin:generate:request:store', [
            'table_name' => 'categories',
            '--model-name' => 'Billing\\Cat',
        ]);

        $this->assertFileExists($filePath);
        $this->assertStringStartsWith('<?php namespace App\Http\Requests\Admin\Cat;

use Illuminate\Foundation\Http\FormRequest;
use Gate;

class StoreCat extends FormRequest', File::get($filePath));
    }

}
