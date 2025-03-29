<?php
namespace SSolWEB\LaravelBrFormatter\Tests\Casts;

use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase;
use SSolWEB\LaravelBrFormatter\Tests\Models\TestModel;

class CpfCastTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function testCpfCast()
    {
        $model = new TestModel();
        $model->cpf = '123.456.789-09';
        // Testa se o CPF foi armazenado sem formatação
        $this->assertEquals('12345678909', $model->getAttributes()['cpf']);
        // Testa se o CPF foi formatado corretamente ao recuperar
        $this->assertEquals('123.456.789-09', $model->cpf);
    }
}
