<?php

namespace SSolWEB\LaravelBrFormatter\Tests\Casts;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;
use SSolWEB\LaravelBrFormatter\Casts\CpfCast;

class CpfCastTest extends TestCase
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

    public function testCpfCast()
    {
        $model = new class extends Model {
            protected $casts = ['cpf' => CpfCast::class];
        };
        $model->cpf = '12345678909';
        $this->assertEquals('12345678909', $model->getAttributes()['cpf']);
        $this->assertEquals('123.456.789-09', $model->cpf);
    }

    public function testCpfFormated()
    {
        $model = new class extends Model {
            protected $casts = ['cpf' => CpfCast::class];
        };
        $model->cpf = '123.456.789-09';
        $this->assertEquals('12345678909', $model->getAttributes()['cpf']);
        $this->assertEquals('123.456.789-09', $model->cpf);
    }

    public function testFillable()
    {
        $model = new class (['cpf' => '12345678909']) extends Model {
            protected $fillable = ['cpf'];
            protected $casts = ['cpf' => CpfCast::class];
        };
        $this->assertEquals('12345678909', $model->getAttributes()['cpf']);
        $this->assertEquals('123.456.789-09', $model->cpf);
    }

    public function testNull()
    {
        $model = new class extends Model {
            protected $casts = ['cpf' => CpfCast::class];
        };
        $model->cpf = null;
        $this->assertEquals(null, $model->getAttributes()['cpf']);
        $this->assertEquals(null, $model->cpf);
    }
}
