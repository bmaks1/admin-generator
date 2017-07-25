<?php namespace Brackets\AdminGenerator\Generate;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class Controller extends Generator {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'admin:generate:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a controller class';

    /**
     * Path for view
     *
     * @var string
     */
    protected $view = 'controller';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        //TODO check if exists
        //TODO make global for all generator
        //TODO also with prefix
        if(!empty($template = $this->option('template'))) {
            $this->view = 'templates.'.$template.'.controller';
        }

        if(!empty($belongsToMany = $this->option('belongsToMany'))) {
            $this->setBelongToManyRelation($belongsToMany);
        }

        $controllerPath = base_path($this->getPathFromClassName($this->controllerFullName));

        if ($this->alreadyExists($controllerPath)) {
            $this->error('File '.$controllerPath.' already exists!');
            return false;
        }

        $this->makeDirectory($controllerPath);

        $this->files->put($controllerPath, $this->buildClass());

        $sidebarPath = resource_path('views/admin/layout/sidebar.blade.php');
        if(!$this->alreadyAppended($sidebarPath, "<li class=\"nav-item\"><a class=\"nav-link\" href=\"{{ url('admin/".$this->modelRouteAndViewName."') }}\"><i class=\"icon-list\"></i> ".$this->modelPlural."</a></li>")) {
            $this->files->put($sidebarPath, str_replace("{{-- Do not delete me :) I'm used for auto-generation menu items --}}", "<li class=\"nav-item\"><a class=\"nav-link\" href=\"{{ url('admin/".$this->modelRouteAndViewName."') }}\"><i class=\"icon-list\"></i> ".$this->modelPlural."</a></li>\n            {{-- Do not delete me :) I'm used for auto-generation menu items --}}", $this->files->get($sidebarPath)));
        }

        $this->info('Generating '.$this->controllerBaseName.' finished');

    }

    protected function buildClass() {

        return view('brackets/admin-generator::'.$this->view, [
            'controllerBaseName' => $this->controllerBaseName,
            'controllerNamespace' => $this->controllerNamespace,
            'modelBaseName' => $this->modelBaseName,
            'modelFullName' => $this->modelFullName,
            'modelPlural' => $this->modelPlural,
            'modelVariableName' => $this->modelVariableName,
            'modelRouteAndViewName' => $this->modelRouteAndViewName,

            // index
            'columnsToQuery' => $this->readColumnsFromTable($this->tableName)->filter(function($column) {
                return !($column['type'] == 'text' || $column['name'] == "password" || $column['name'] == "remember_token" || $column['name'] == "slug" || $column['name'] == "created_at" || $column['name'] == "updated_at" || $column['name'] == "deleted_at");
            })->pluck('name')->toArray(),
            'columnsToSearchIn' => $this->readColumnsFromTable($this->tableName)->filter(function($column) {
                return ($column['type'] == 'text' || $column['type'] == 'string' || $column['name'] == "id") && !($column['name'] == "password" || $column['name'] == "remember_token");
            })->pluck('name')->toArray(),
//            'filters' => $this->readColumnsFromTable($tableName)->filter(function($column) {
//                return $column['type'] == 'boolean' || $column['type'] == 'date';
//            }),
            //TODO change to better check
            'userGeneration' => $this->tableName == 'users',

            // validation in store/update
            'columns' => $this->getVisibleColumns($this->tableName, $this->modelVariableName),
            'relations' => $this->relations,
        ])->render();
    }

    protected function getOptions() {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generates a controller for the given model'],
            ['controller', 'c', InputOption::VALUE_OPTIONAL, 'Specify custom controller name'],
            ['template', 't', InputOption::VALUE_OPTIONAL, 'Specify custom template'],
            ['belongsToMany', 'btm', InputOption::VALUE_OPTIONAL, 'Specify belongs to many relations'],
        ];
    }

}