<?php

namespace SSolWEB\LaravelBrHelper\Tests\Casts;

use Illuminate\Database\Eloquent\Model;
use Orchestra\Testbench\TestCase;
use SSolWEB\LaravelBrHelper\Casts\CpfCast;
use SSolWEB\LaravelBrHelper\Enums\DBType;

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

    public function testCpfCastAsDefault()
    {
        $model = new class extends Model {
            protected function casts(): array
            {
                return ['cpf' => CpfCast::class];
            }
        };
        $model->cpf = '123.456.789-09';
        $this->assertEquals('12345678909', $model->getAttributes()['cpf']);
        $this->assertEquals('123.456.789-09', $model->cpf);
        // tests fillable
        $model = new class (['cpf' => '12345678909']) extends Model {
            protected $fillable = ['cpf'];

            protected function casts()
            {
                return ['cpf' => CpfCast::class];
            }
        };
        $this->assertEquals('12345678909', $model->getAttributes()['cpf']);
        $this->assertEquals('123.456.789-09', $model->cpf);
    }

    public function testCpfCastAsString()
    {
        $model = new class extends Model {
            protected function casts()
            {
                return ['cpf' => CpfCast::dbType(DBType::STRING)];
            }
        };
        $model->cpf = '123.456.789-09';
        $this->assertEquals('12345678909', $model->getAttributes()['cpf']);
        $this->assertEquals('123.456.789-09', $model->cpf);
    }

    public function testCpfCastAsInteger()
    {
        $model = new class extends Model {
            protected function casts()
            {
                return ['cpf' => CpfCast::dbType(DBType::INTEGER)];
            }
        };
        $model->cpf = '123.456.789-09';
        $this->assertEquals(12345678909, $model->getAttributes()['cpf']);
        $this->assertEquals('123.456.789-09', $model->cpf);
        // starting by zero
        $model->cpf = '023.456.789-09';
        $this->assertEquals(2345678909, $model->getAttributes()['cpf']);
        $this->assertEquals('023.456.789-09', $model->cpf);
    }

    public function testCpfCastAsFormatted()
    {
        $model = new class extends Model {
            protected function casts()
            {
                return ['cpf' => CpfCast::dbType(DBType::FORMATTED)];
            }
        };
        $model->cpf = '12345678909';
        $this->assertEquals('123.456.789-09', $model->getAttributes()['cpf']);
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

    public function testEmptyString()
    {
        $model = new class extends Model {
            protected $casts = ['cpf' => CpfCast::class];
        };
        $model->cpf = '';
        $this->assertEquals(null, $model->getAttributes()['cpf']);
        $this->assertEquals(null, $model->cpf);
    }

    public function testInvalidTypes()
    {
        $model = new class extends Model {
            protected $casts = ['cpf' => CpfCast::class];
        };
        $model->cpf = ['invalid_array'];
        $this->assertEquals(null, $model->getAttributes()['cpf']);
        $this->assertEquals(null, $model->cpf);

        $model->cpf = true;
        $this->assertEquals(null, $model->getAttributes()['cpf']);
        $this->assertEquals(null, $model->cpf);
    }

    public function testInvalidLengthAndCharacters()
    {
        $model = new class extends Model {
            protected $casts = ['cpf' => CpfCast::class];
        };
        $model->cpf = '1234';
        $this->assertEquals('00000001234', $model->getAttributes()['cpf']);
        $this->assertEquals('000.000.012-34', $model->cpf);

        $model->cpf = '1234abcd';
        $this->assertEquals('00000001234', $model->getAttributes()['cpf']);
        $this->assertEquals('000.000.012-34', $model->cpf);
    }
}
