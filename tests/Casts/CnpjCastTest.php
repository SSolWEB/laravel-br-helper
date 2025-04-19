<?php

namespace SSolWEB\LaravelBrHelper\Tests\Casts;

use Illuminate\Database\Eloquent\Model;
use Orchestra\Testbench\TestCase;
use SSolWEB\LaravelBrHelper\Casts\CnpjCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

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

    public function testCnpjCastAsDefault()
    {
        $model = new class extends Model {
            protected function casts(): array
            {
                return ['cnpj' => CnpjCast::class];
            }
        };
        $model->cnpj = '11.222.333/0001-44';
        $this->assertEquals('11222333000144', $model->getAttributes()['cnpj']);
        $this->assertEquals('11.222.333/0001-44', $model->cnpj);
        // tests fillable
        $model = new class (['cnpj' => '11222333000144']) extends Model {
            protected $fillable = ['cnpj'];

            protected function casts()
            {
                return ['cnpj' => CnpjCast::class];
            }
        };
        $this->assertEquals('11222333000144', $model->getAttributes()['cnpj']);
        $this->assertEquals('11.222.333/0001-44', $model->cnpj);
    }

    public function testCnpjCastAsString()
    {
        $model = new class extends Model {
            protected function casts()
            {
                return ['cnpj' => CnpjCast::dbType(DBType::STRING)];
            }
        };
        $model->cnpj = '11.222.333/0001-44';
        $this->assertEquals('11222333000144', $model->getAttributes()['cnpj']);
        $this->assertEquals('11.222.333/0001-44', $model->cnpj);
    }

    public function testCnpjCastAsInteger()
    {
        $model = new class extends Model {
            protected function casts()
            {
                return ['cnpj' => CnpjCast::dbType(DBType::INTEGER)];
            }
        };
        $model->cnpj = '11.222.333/0001-44';
        $this->assertEquals(11222333000144, $model->getAttributes()['cnpj']);
        $this->assertEquals('11.222.333/0001-44', $model->cnpj);
        // passing integer value
        $model->cnpj = 11222333000144;
        $this->assertEquals(11222333000144, $model->getAttributes()['cnpj']);
        $this->assertEquals('11.222.333/0001-44', $model->cnpj);
        // starting by zero
        $model->cnpj = '01.222.333/0001-44';
        $this->assertEquals(1222333000144, $model->getAttributes()['cnpj']);
        $this->assertEquals('01.222.333/0001-44', $model->cnpj);
    }

    public function testCnpjCastAsFormatted()
    {
        $model = new class extends Model {
            protected function casts()
            {
                return ['cnpj' => CnpjCast::dbType(DBType::FORMATTED)];
            }
        };
        $model->cnpj = '11222333000144';
        $this->assertEquals('11.222.333/0001-44', $model->getAttributes()['cnpj']);
        $this->assertEquals('11.222.333/0001-44', $model->cnpj);
        // starting by zero
        $model->cnpj = '1222333000144';
        $this->assertEquals('01.222.333/0001-44', $model->getAttributes()['cnpj']);
        $this->assertEquals('01.222.333/0001-44', $model->cnpj);
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
