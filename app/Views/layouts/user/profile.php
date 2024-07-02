<?php
layout("principal/Modal");


class Profile{

    private object $user;
    private object $orders;
    private string $html = "";

    public function __construct(array $data){
        $this->user = arrayToObject($data['user']);
        $this->orders = arrayToObject($data['orders']);
    }



    public function emailCard(){
        $this->card("Email", $this->user->row->email, false);
    }

    
    public function name(){
        $this->card("Nombre", $this->user->row->name, true, route("/api/v1/updateName", false), [
            [
                "label" => "Editar Nombre",
                "name" => "name"
            ]
        ]);
    }

    public function user(){
        $this->card("Usuario", $this->user->row->user, true, route("/api/v1/updateUser", false), [
            [
                "label" => "Editar usuario",
                "name" => "user"
            ]
        ]);
    }

    public function createAcount(){
        $this->card("Fecha y hora creacion de la cuenta", $this->user->row->created_at, false);
    }

    public function numOrders(){
        $this->card("Numero de ordenes creadas", $this->orders->count, false);
    }

    public function address(){
        $this->card("Departamento", "San Salvador", true, "/action", [
            [
                'type' => "select",
                'label' => "estoe s un label xd",
                'name' => 'departament',
                'options' => [
                    "1" => "hola"
                ]
            ]
        ]);
    }

    public function addTitle(string $title, string $message = ''){
        $this->html .= "<div class='py-2'>";
        $this->html .= "<h2 class='text-2xl font-semibold text-gray-800'>$title</h2>";
        $this->html .= "</div>";
        if (!empty($message)) {
            $this->html .= "<div class='text-sm text-gray-600'>$message</div>";
        }
        $this->html .= "<div class='my-6 border-gray-300'></div>";
    }
    
    /* 
    
        [
            [
                type => text, (default text)
                label => "titulo"
                name => nameSend,
                value => valueOptional, (default "")

            ]
        ]
    */
    public function card(string $title, string $content, bool $edit = true, string $actionUrl = "", array $formInputs = []) {
        $modal = null;
        $html = '';
        if ($edit) {
            $modal = new Modal($title, $actionUrl);
            $form = '';
    
            foreach ($formInputs as $input) {
                $value = $input['value'] ?? "";
                $type = $input['type'] ?? 'text';
                if($type == "textarea"){
                    $form .= $modal->form()->textarea($input['label'], $input['name'], $value);
                }else if($type == 'select'){
                    $form .= $modal->form()->select(
                        $input['label'],
                        $input['name'],
                        $input['options']
                    );
                }else if($type == 'text'){
                    $form .= $modal->form()->input($input['label'], $input['name'], $value, $type);
                }
            }
    
            $modal->setHtmlToRender($form);
            $idButton = $modal->getId();
    
            $html .= '<div class="mb-6 border border-gray-300 rounded p-4">
                <div class="flex justify-between flex-wrap gap-2 w-full">
                    <span class="text-gray-700 font-bold">' . $title . '</span>
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-sm py-1 px-2 rounded" data-bs-toggle="modal" data-bs-target="#'.$idButton.'">
                        Editar
                    </button>
                </div>
                <p class="mt-1">' . $content . '</p>
            </div>';
        } else {
            $html .= '<div class="mb-6 border border-gray-300 rounded p-4">
                <div class="flex justify-between flex-wrap gap-2 w-full">
                    <span class="text-gray-700 font-bold">' . $title . '</span>
                </div>
                <p class="mt-1">' . $content . '</p>
            </div>';
        }
        
        //considerar que es mejor, si primero el modal o el html
        $modal = $modal == null ? "" : $modal->get();
        $this->html .= $html.$modal;
    }
    
    public function get() : string{
        return $this->html;
    }

    public function render() : void{
        echo $this->get();
    }
}