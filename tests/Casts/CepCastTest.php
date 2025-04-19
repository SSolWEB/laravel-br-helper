<?php

namespace SSolWEB\LaravelBrHelper\Tests\Casts;

use Illuminate\Database\Eloquent\Model;
use Orchestra\Testbench\TestCase;
use SSolWEB\LaravelBrHelper\Casts\CepCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

class CepCastTest extends TestCase
{
    public function testCepCast()
    {
        $model = new class extends Model {
            protected $casts = ['cep' => CepCast::class];
        };
        $model->cep = '44555666';
        $this->assertEquals('44555666', $model->getAttributes()['cep']);
        $this->assertEquals('44.555-666', $model->cep);
    }

    public function testCepFormated()
    {
        $model = new class extends Model {
            protected $casts = ['cep' => CepCast::class];
        };
        $model->cep = '44.555-666';
        $this->assertEquals('44555666', $model->getAttributes()['cep']);
        $this->assertEquals('44.555-666', $model->cep);
    }

    public function testFillable()
    {
        $model = new class (['cep' => '44555666']) extends Model {
            protected $fillable = ['cep'];
            protected $casts = ['cep' => CepCast::class];
        };
        $this->assertEquals('44555666', $model->getAttributes()['cep']);
        $this->assertEquals('44.555-666', $model->cep);
    }

    public function testCepCastAsDefault()
    {
        $model = new class extends Model {
            protected function casts(): array
            {
                return ['cep' => CepCast::class];
            }
        };
        $model->cep = '44.555-666';
        $this->assertEquals('44555666', $model->getAttributes()['cep']);
        $this->assertEquals('44.555-666', $model->cep);
        // tests fillable
        $model = new class (['cep' => '44555666']) extends Model {
            protected $fillable = ['cep'];

            protected function casts()
            {
                return ['cep' => CepCast::class];
            }
        };
        $this->assertEquals('44555666', $model->getAttributes()['cep']);
        $this->assertEquals('44.555-666', $model->cep);
    }

    public function testCepCastAsString()
    {
        $model = new class extends Model {
            protected function casts()
            {
                return ['cep' => CepCast::dbType(DBType::STRING)];
            }
        };
        $model->cep = '44.555-666';
        $this->assertEquals('44555666', $model->getAttributes()['cep']);
        $this->assertEquals('44.555-666', $model->cep);
    }

    public function testCepCastAsInteger()
    {
        $model = new class extends Model {
            protected function casts()
            {
                return ['cep' => CepCast::dbType(DBType::INTEGER)];
            }
        };
        $model->cep = '44.555-666';
        $this->assertEquals(44555666, $model->getAttributes()['cep']);
        $this->assertEquals('44.555-666', $model->cep);
        // passing integer value
        $model->cep = 44555666;
        $this->assertEquals(44555666, $model->getAttributes()['cep']);
        $this->assertEquals('44.555-666', $model->cep);
        // starting by zero
        $model->cep = '04.555-666';
        $this->assertEquals(4555666, $model->getAttributes()['cep']);
        $this->assertEquals('04.555-666', $model->cep);
    }

    public function testCepCastAsFormatted()
    {
        $model = new class extends Model {
            protected function casts()
            {
                return ['cep' => CepCast::dbType(DBType::FORMATTED)];
            }
        };
        $model->cep = '44555666';
        $this->assertEquals('44.555-666', $model->getAttributes()['cep']);
        $this->assertEquals('44.555-666', $model->cep);
    }

    public function testNull()
    {
        $model = new class extends Model {
            protected $casts = ['cep' => CepCast::class];
        };
        $model->cep = null;
        $this->assertEquals(null, $model->getAttributes()['cep']);
        $this->assertEquals(null, $model->cep);
    }
}
