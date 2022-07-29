<?php
class Fluent 
{

    public $return;

    public function a()
    {
        $this->return = "a &nbsp;&nbsp;&nbsp;";
        echo $this->return;
        return $this;
    }

    public function b()
    {
        $this->return = "b &nbsp;&nbsp;&nbsp;";
        echo $this->return;
        return $this;
    }

    public function c()
    {
        $this->return = "c &nbsp;&nbsp;&nbsp;";
        echo $this->return;
        return $this;
    }

    public function d()
    {
        $this->return = "d &nbsp;&nbsp;&nbsp;";
        echo $this->return;
        return $this;
    }

    public function __toString(): string
    {
        return sprintf(
            'Kullanımı : ',
            $this->a(),
            $this->b(),
            $this->c(),
            $this->d()
        );
    }

}
$fluent = new Fluent();
//var_dump( $fluent->a()->b() );

echo '<br>';

$fluent->a()
       ->b()
       ->c(); 

?>
