<?php

namespace SSolWEB\LaravelBrHelper\Tests\Casts;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;
use SSolWEB\LaravelBrHelper\Casts\CepCast;

class CepCastTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $capsule = new Capsule();
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

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
