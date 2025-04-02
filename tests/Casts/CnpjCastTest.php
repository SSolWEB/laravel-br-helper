<?php

namespace SSolWEB\LaravelBrHelper\Tests\Casts;

use Illuminate\Database\Eloquent\Model;
use Orchestra\Testbench\TestCase;
use SSolWEB\LaravelBrHelper\Casts\CnpjCast;

class CnpjCastTest extends TestCase
{
    public function testCnpjCast()
    {
        $model = new class extends Model {
            protected $casts = ['cnpj' => CnpjCast::class];
        };
        $model->cnpj = '11222333000144';
        $this->assertEquals('11222333000144', $model->getAttributes()['cnpj']);
        $this->assertEquals('11.222.333/0001-44', $model->cnpj);
    }

    public function testCnpjFormated()
    {
        $model = new class extends Model {
            protected $casts = ['cnpj' => CnpjCast::class];
        };
        $model->cnpj = '11.222.333/0001-44';
        $this->assertEquals('11222333000144', $model->getAttributes()['cnpj']);
        $this->assertEquals('11.222.333/0001-44', $model->cnpj);
    }

    public function testFillable()
    {
        $model = new class (['cnpj' => '11222333000144']) extends Model {
            protected $fillable = ['cnpj'];
            protected $casts = ['cnpj' => CnpjCast::class];
        };
        $this->assertEquals('11222333000144', $model->getAttributes()['cnpj']);
        $this->assertEquals('11.222.333/0001-44', $model->cnpj);
    }

    public function testNull()
    {
        $model = new class extends Model {
            protected $casts = ['cnpj' => CnpjCast::class];
        };
        $model->cnpj = null;
        $this->assertEquals(null, $model->getAttributes()['cnpj']);
        $this->assertEquals(null, $model->cnpj);
    }
}
