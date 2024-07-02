<?php


class ProductShow{

    private string $image, $categorie, $name, $price, $stock, $html, $idButtonAddToCard, $partnerName;
    private array $socialMedia, $description, $button;
    
    function __construct(array $productData){
        $this->image = $productData['image'];
        $this->name = $productData['name'];
        $this->price = $productData['price'];
        $this->categorie = $productData['category'];
        $this->socialMedia = $productData['socialMedia'] ?? [];
        $this->description = $productData['descriptions'];
        $this->stock = $productData['stock'];
        $this->button = $productData['button'];
        $this->partnerName = $productData['partner_name'];
        $this->idButtonAddToCard = $this->generateId();
    }
    

    private function generateId() {
        return "button_add_to_card_" . uniqid();
    }

    private function start(){
        $html = '<div class="pt-20">'; 
        $html .= '<section class="text-gray-600 body-font overflow-hidden">';
        $html .= '<div class="container px-5 py-24 mx-auto">';
        $html .= '<div class="lg:w-4/5 mx-auto flex flex-wrap">';
        return $html;
    }

    private function image(){
        $html = '<img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover';
        $html .= 'object-center rounded" data-lightbox="roadtrip"';
        $html .= 'src="'.$this->image.'">';
        return $html;
    }

    private function categorie(){
        return '<div class="mb-4">
                    <h2 class="text-lg font-medium text-gray-700">' . $this->categorie . '</h2>
                    <p class="text-sm text-gray-500">Powered by <b>' . $this->partnerName . '</b></p>
                </div>';
    }
    
    
    private function name(){
        return '<h1 class="text-gray-900 text-3xl title-font font-medium mb-1">'.$this->name.'</h1>';
    }

    private function icons(){
        $builder = new StringBuilder('<div class="flex mb-4">');
        $builder->append('<span class="flex ml-3 pl-3 py-2 border-l-2 border-gray-200 space-x-2s">')
                ->append($this->twiterIcon())
                ->append(" </span> </div>");
        return $builder->toString();
    }

    private function description(){
        $builder = new StringBuilder();
        if(isset($this->description['short'])){
            $builder->append('<p class="leading-relaxed">'.$this->description['short'].'</p>');
        }
        
        if(isset($this->description['large'])){
            $builder->append('<div class="flex mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">')
                    ->append($this->description['large'])
                    ->append('</div>');
        }
        return $builder->toString();
    }

    private function twiterIcon(){
        $builder = null;
        if(isset($this->socialMedia['twiter']) && isset($this->socialMedia['twiter']['link'])){
            $builder = new StringBuilder('<a class="text-gray-500" href="'.$this->socialMedia['twiter']['link'].'">');
            $builder->append('<svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round"')
                    ->append('stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">')
                    ->append('<path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86')
                    ->append('3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0')
                    ->append('20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>')
                    ->append('</svg> </a>');
        }
        return $builder == null ? '' : $builder->toString();
    }


    private function price(){
        $builder = new StringBuilder('<div class="mr-20">');
        $builder->append('<p class="text-gray-600">Precio:</p>');
        $builder->append('<p class="text-2xl font-medium text-gray-900">$'.$this->price.'</p>');
        $builder->append('</div>');
        return $builder->toString();
    }
    

    private function stock(){
        $builder = new StringBuilder("<div>");
        $builder->append('<p class="text-gray-600">En stock:</p>');
        $builder->append('<p class="text-2xl font-medium text-gray-900">'.$this->stock.'</p>');
        $builder->append("</div>");
        return $builder->toString();
    }

    private function buildStokcAndPrice(){
        $builder = new StringBuilder(' <div class="flex items-center mt-4">');
        $builder->append($this->price())
                ->append($this->stock())
                ->append('</div>');
        return $builder->toString();
    }
    

    private function button(string $string,  string $modalId){
        $builder = new StringBuilder('<button class="flex mt-4 lg:mt-0 text-white bg-gradient-to-r ');
        $builder->append('from-purple-500 to-purple-600 border-0 py-2 px-6 focus:outline-none ')
                ->append('hover:bg-purple-600 rounded-md shadow-md" data-bs-toggle="modal" data-bs-target="#'.$modalId.'">'.$string.'</button>');
        return $builder->toString();
    }
    

    private function buttonOrder(){
        $builder = new StringBuilder();
        if(isset($this->button['order']['modalId']) && isset($this->button['order']['string'])){
            $builder->append($this->button(
                $this->button['order']['string'],
                $this->button['order']['modalId']
            ));
        }

        return $builder->toString();
    }

    private function buttonAddToCart(){
        return $this->button("Agregar al carrito", $this->idButtonAddToCard);
    }

    private function end(){
        $builder = new StringBuilder("</div>");
        $builder->append("</div></div></div> </section> </div>");
        return $builder->toString();
    }


    public function build(){
       $builder = new StringBuilder($this->start());
       $builder->append($this->image())
               ->append('<div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">')
               ->append($this->categorie())
               ->append($this->name())
               ->append($this->icons())
               ->append($this->description())
               ->append('<div class="flex flex-col lg:flex-row justify-between">')
               ->append($this->buildStokcAndPrice())
               ->append($this->buttonOrder())
               ->append($this->end());
        $this->html = $builder->toString();
    }

    public function render(){
        $this->build();
        echo $this->html;
    }
}