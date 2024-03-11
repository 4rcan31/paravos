<?php


class CategoriesApp{

    public array $data;
    public string $html;

    function __construct($data)
    {
        $this->data = $data;
    }

    function start()
    {
        $html = '<div class="products">';
        $html .= '<div class="container">';
        $html .= ' <div class="row">';
        return $html;
    }

    private function end(){
        return '    </div>
        </div>
      </div>';
    }

    private function pagination(){
        $html = '         <div class="col-md-12">
        <ul class="pages">
          <li><a href="#">1</a></li>
          <li class="active"><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
        </ul>
      </div>';

      $html .= "
        <script>
            // Como puedo controlar la paginacion desde javascript
        </script>
      ";

      return $html;
    }


    private function buildSearcher(): string
    {
        $html = '<div class="col-md-12">';
        $html .= ' <div class="filters">';
        $html .= '<ul>';
        $html .= '<li class="active" data-filter="*">Todos los productos</li>';
        foreach ($this->data as $categories => $value) {
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

        foreach ($this->data as $categories => $value) {
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
