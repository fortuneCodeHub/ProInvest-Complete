<?php
//Namespace
namespace app\model;

//Don't allow access to this page
defined("ROOTPATH") or exit("Access Denied");

/**
 * Pagination Class
 */

class Pagination
{
    protected $limit = "";
    protected $start = "";
    protected $previous = "";
    protected $next = "";
    protected $model = "";
    protected $table_data = [];
    protected $pages = "";
    protected $total = "";

    public $nav_class = "";
    public $ul_class = "pagination justify-content-center";
    public $li_class = "page-item";
    public $a_class = "page-link";
    public $nav_styles = "";
    public $ul_styles = "";
    public $li_styles = "";
    public $a_styles = "color: black;";
    public $first_a_styles = "";
    public $first_li_styles = "";
    public $next_a_styles = "";
    public $next_li_styles = "";

    public $select_class = "";
    public $select_styles = "";
    public $option_class = "";
    public $option_styles = "";
    public $limit_btn_class = "btn btn-sm";
    public $limit_btn_styles = "";

    public $inputFilterclass = "";
    public $inputFilterstyles = "";
    public $btnFilterclass = "";
    public $btnFilterstyles = "";
    public $btnClearclass = "";
    public $btnClearstyles = "";
    
    public function __construct($model)
    {
        $ses = new \app\model\Session();

        if (isset($_POST["limit-records"])) {
            $_GET["page"] = 1;
            $ses->set("limit-records",$_POST["limit-records"]);
            $this->limit = $_POST["limit-records"];
        } else {
            if (!empty($ses->get("limit-records"))) {
                $this->limit = $ses->get("limit-records");
            } else {
                $this->limit = $ses->set("limit-records",2);
            }
            
        }

        $page = isset($_GET["page"]) ? $_GET["page"] : 1;

        $start = ($page - 1) * $this->limit;
        $this->start = $start;
        if (empty($model)) {
            die("Please input Model name");
        }
        $this->model = ucfirst($model);
        $model = "\app\model\\$this->model";
        $table_data = new $model();
        $table_data = $table_data->query("SELECT * FROM {$table_data->table} LIMIT {$this->start}, {$this->limit}");
        $this->table_data = $table_data;

        $count = new $model();
        $Count = $count->query("SELECT count(id) AS id FROM {$count->table}");
        $total = $Count[0]["id"];
        $this->total = $total;

        $pages = ceil($this->total / $this->limit);
        $this->pages = $pages;

        $Previous = ($page == 1) ? 1 : $page - 1;
        $this->previous = $Previous;
        $Next = ($page == $this->pages) ? $this->pages : $page + 1;
        $this->next = $Next;
    }

    public function filter_sort()
    {
        $data = [];
        $error = [];
        $sorts = [];

        $model = "\app\model\\$this->model";
        $content = new $model();
        $values = $content->query("SELECT * FROM $content->table");
        //Get sorts all the possible sorts from database
        foreach ($values as $key => $value) {
            if ($key === 1) {
                break;
            }
            $sorts = array_keys($value);
            foreach ($sorts as $keys) {
                $sorts[] = $keys;
            }
        }

        $sql = "SELECT * FROM $content->table ";

        //Check for and apply filter
        if (isset($_POST["filter"])) {
            $filter = trim($_POST["filter"]);
            if(isset($_POST["btnFilter"])){
                $sql .= " WHERE name LIKE :name";
                $data["name"] = "%$filter%";
                $_SESSION["filter"] = $filter;
            }
        } else {
            if (isset($_SESSION["filter"]) && strlen($_SESSION["filter"]) > 0) {
                $filter = $_SESSION["filter"];
                $sql .= " WHERE name LIKE :name";
                $data["name"] = "%$filter%";
            }
        }

        //add the sort
        if (isset($_GET["sort"]) && strlen(trim($_GET["sort"])) > 0) {
            $sort = addslashes(trim($_GET["sort"]));
            if (in_array($sort, $sorts)) {
                $sql .= " ORDER BY $sort";
            } else {
                $error["sort"] = "No such $sort sort found";
            }
        }

        //Clear Old filters
        if (isset($_POST["btnClear"])) {
            unset($_POST["filter"]);
            unset($_SESSION["filter"]);
        }

        $sql .= " LIMIT $this->start, {$this->limit}";

        $this->table_data = $content->query($sql,$data);

    }

    public function display_filter() 
    {
        ?>
        <form action="" method="post" class="filterForm" enctype="multipart/form-data" >
            <input type="text" id="filter" name="filter" autofocus="true" placeholder="filter" value="<?=old_value("filter"); ?>" class="<?=$this->inputFilterclass;?>" style="<?=$this->inputFilterstyles;?>" >
            <input type="submit" name="btnFilter" id="btnFilter" value="Go" class="<?=$this->btnFilterclass;?>" style="<?=$this->btnFilterstyles;?>" >
            <input type="submit" name="btnClear" id="btnClear" value="Clear Filters" class="<?=$this->btnClearclass;?>" style="<?=$this->btnClearstyles;?>" >
        </form>
        <?php
    }

    public function display_table() 
    {
        return $this->table_data;
    }

    public function display_pager()
    {
        ?>
        <nav aria-label="Pagination example" class="<?=$this->nav_class;?>" style="<?=$this->nav_styles;?>">
            <ul class="<?=$this->ul_class?>" style="<?=$this->nav_styles;?>">
                <li class="<?=$this->next_li_styles;?><?=$this->li_class;?>" style="<?=$this->li_styles?>">
                    <a href="?page=<?=$this->previous;?>" class="<?=$this->next_a_styles;?><?=$this->a_class?>" style="<?=$this->a_styles?>">&laquo; Previous</a>
                </li>
                <?php for ($i=1; $i <= $this->pages; $i++) { ?> 
                    <li class="<?=$this->li_class;?>" style="<?=$this->li_styles?>"><a class="<?=$this->a_class?>" style="<?=$this->a_styles?>" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li class="<?=$this->next_li_styles;?><?=$this->li_class;?>" style="<?=$this->li_styles?>">
                    <a href="?page=<?=$this->next;?>" class="<?=$this->a_class?><?=$this->next_a_styles;?>" style="<?=$this->a_styles?>">Next &raquo;</a>
                </li>
            </ul>
        </nav>   
    <?php 
    
    }

    public function display_limitRecords($data)
    {
        if (empty($data)) {
            die("Please input data in form of an array into the function");
        }
        ?>
            <form action="" method="post">
                <div class="">
                    <select name="limit-records" id="limit-records" class="<?=$this->select_class?>" style="<?=$this->select_styles?>">
                        <option disabled selected>--Limit Records---</option>
                        <?php foreach ($data as $limit) { ?>
                            <option class="<?=$this->option_class?>" style="<?=$this->option_styles?>" <?php if (isset($_POST["limit-records"]) && $_POST["limit-records"] == $limit) { echo "Selected"; } ?> value="<?=$limit?>"><?=$limit?></option>
                        <?php } ?>
                    </select>
                    <button class="<?=$this->limit_btn_class?>" type="submit" style="<?=$this->limit_btn_styles?>" >SET</button>
                </div>
            </form>
        <?php 
    }
}