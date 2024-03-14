<?php


class CategoriesApp{

    public array $data;
    public array $products;
    public string $html;
    public int $page;
    public string $uriRedirection;
    public int $totalpages;
    public int $maxButtonsShow;
    public bool $scroll;

    function __construct($data, $uri, $scroll = false){
        $this->data = $data;
        $this->products = $this->data['products'];
        $this->page = $this->data['page'];
        $this->uriRedirection = $uri;
        $this->totalpages = $data['totalpages'];
        $this->maxButtonsShow = $data['maxButtonsShow'];
        $this->scroll = $scroll;
    }

    function start()
    {
        $html = '<div class="products">';
        $html .= '<div class="container">';
        $html .= ' <div class="row">';
        return $html;
    }

    private function end(){
        $js = '
        <script>
            scrollToElement("scrolling-show-products"); //creo que esto no esta funcionando xd
        </script>
        ';
        return '    </div>
        </div>
      </div>'.$js;
    }

    private function pagination() {
        $totalPages = $this->totalpages;
        $currentPage = $this->page;
        $html = '<div class="col-md-12">';
        $html .= '<ul class="pages">';
        $startPage = max(1, $currentPage - floor($this->maxButtonsShow / 2));
        $endPage = min($totalPages, $startPage + $this->maxButtonsShow - 1);
        if ($currentPage > 1) {
            $html .= '<li><a href="' . $this->pageUrl(1) . '"><i class="fa fa-angle-double-left"></i></a></li>';
        }
        for ($i = $startPage; $i <= $endPage; $i++) {
            $class = ($i == $currentPage) ? 'class="active"' : '';
            $html .= '<li ' . $class . '><a href="' . $this->pageUrl($i) . '">' . $i . '</a></li>';
        }
        if ($currentPage < $totalPages) {
            $html .= '<li><a href="' . $this->pageUrl($totalPages) . '"><i class="fa fa-angle-double-right"></i></a></li>';
        }
    
        $html .= '</ul>';
        $html .= '</div>';
        return $html;
    }
    

    private function pageUrl($page) {
        return $this->uriRedirection . "/" . $page;
    }

    private function buildSearcher(): string
    {
        $html = '<div class="col-md-12" id="scrolling-show-products">';
        $html .= ' <div class="filters">';
        $html .= '<ul>';
        $html .= '<li class="active" data-filter="*">Todos los productos</li>';
        foreach ($this->products as $categories => $value) {
            $html .= '<li data-filter=".' . $categories . '">' . $categories . '</li>';
        }
        $html .= '</ul>
        </div>
      </div>';
        return $html;
    }

    private function products(){
        $html = '          <div class="col-md-12">
        <div class="filters-content">
            <div class="row grid">';
        foreach ($this->products as $categories => $value) {
            for($i = 0; $i < count($value); $i++){
                $name = $value[$i]['name'];
                $html .= $this->product(
                    $name,
                    $value[$i]['img'],
                    $value[$i]['description'],
                    $value[$i]['price'],
                    $categories
                );
            }
        }
        $html .= "           </div>
        </div>
      </div>";

      return $html;
    }

    public function build(){
        $this->html = $this->start();
        $this->html .= $this->buildSearcher();
        $this->html .= $this->products();
        $this->html .= $this->pagination();
        $this->html .= $this->end();
    }

    public function get(){
        return $this->html;
    }

    public function render(){
        $this->build();
        echo $this->get();
    }


    function product($name, $img, $description, $price, $categorie = "", $redirection = "#", $numStart = 0, $numReviews = 0)
    {
        $redirectUrl = htmlspecialchars($redirection);
        $priceFormatted = "$" . htmlspecialchars($price);

        $starsHtml = "";
        if ($numStart != 0) {
            $starsHtml = '<ul class="stars">';
            for ($i = 0; $i < $numStart; $i++) {
                $starsHtml .= '<li><i class="fa fa-star"></i></li>';
            }
            $starsHtml .= "</ul>";
        }

        $reviewsHtml = ($numReviews == 0) ? "" : "Reviews ($numReviews)";
        $html = '
        <div class="col-md-4 col-md-4 all ' . htmlspecialchars($categorie) . '">
            <div class="product-item">
                <a href="' . $redirectUrl . '"><img src="' . htmlspecialchars($img) . '" alt=""></a>
                <div class="down-content">
                    <a href="' . $redirectUrl . '">
                        <h4>' . htmlspecialchars($name) . '</h4>
                    </a>
                    <h6>' . $priceFormatted . '</h6>
                    <p>' . htmlspecialchars($description) . '</p>
                    ' . $starsHtml . '
                    <span>' . $reviewsHtml . '</span>
                </div>
            </div>
        </div>';
        return $html;
    }
}
