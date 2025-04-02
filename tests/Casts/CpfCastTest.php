<?php

namespace SSolWEB\LaravelBrHelper\Tests\Casts;

use Illuminate\Database\Eloquent\Model;
use Orchestra\Testbench\TestCase;
use SSolWEB\LaravelBrHelper\Casts\CpfCast;

class CpfCastTest extends TestCase
{
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
