<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InscricaoResource\Pages;
use App\Filament\Resources\InscricaoResource\RelationManagers;
use App\Mail\CertificadoAprovadoParticipante;
use App\Mail\CertificadoNaoAprovadoParticipante;
use App\Mail\Inscricao as MailInscricao;
use App\Mail\InscricaoRecusada;
use App\Mail\InscricaoStatus;
use App\Models\User;
use App\Models\Acao;
use App\Models\Discente;
use App\Models\Inscricao;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;



class InscricaoResource extends Resource
{
    protected static ?string $model = Inscricao::class;

    protected static ?string $navigationIcon = 'heroicon-s-swatch';

    protected static ?string $navigationLabel = 'Inscrições';

    protected static ?string $modelLabel = 'Inscrição';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Dados Pessoais')
                    ->description('Identificação')
                    ->schema([
                        Section::make()
                            ->schema([
                                Forms\Components\Select::make('acao_id')
                                    ->label('Ação/Evento')
                                    ->required(false)
                                    ->options(Acao::all()->pluck('titulo', 'id')->toArray()),
                                Radio::make('inscricao_tipo')
                                    ->label('Tipo de Inscrição')
                                    ->options([
                                        '1' => 'Discente - IFPE - Campus Garanhuns',
                                        '2' => 'Servidor - IFPE - Campus Garanhuns',
                                        '3' => 'Externo - IFPE - Campus Garanhuns',
                                    ]),
                                Forms\Components\Select::make('user_id')
                                    ->label('Servidor - IFPE - Campus Garanhuns')
                                    ->required(false)
                                    ->options(User::all()->pluck('name', 'id')->toArray()),
                                Forms\Components\TextInput::make('cpf')
                                    ->mask('999.999.999-99')
                                    ->label('CPF'),
                                Forms\Components\Select::make('discente_id')
                                    ->label('Discente - IFPE - Campus Garanhuns')
                                    ->required(false)
                                    ->preload()
                                    ->searchable()
                                    ->relationship('Discente', 'username')
                                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->username} - {$record->name}")
                                    ->searchable(['username', 'name']),
                                Forms\Components\TextInput::make('nome')
                                    ->label('Externo - IFPE - Campus Garanhuns')
                                    ->required(false)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('telefone')
                                    ->required(false)
                                    ->mask('(99)99999-9999')
                                    ->tel(),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required(false)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('instituicao_origem')
                                    ->label('Instituição de Origem')
                                    ->required(false)
                                    ->maxLength(255),
                                Forms\Components\Select::make('escolaridade')
                                    ->label('Escolaridade')
                                    ->required(false)
                                    ->options([
                                        '1' => 'Não Alfabetizado',
                                        '2' => 'Fundamental I - Incompleto',
                                        '3' => 'Fundamental I - Completo',
                                        '4' => 'Fundamental II - Incompleto',
                                        '5' => 'Fundamental II - Completo',
                                        '6' => 'Ensino Médio - Incompleto',
                                        '7' => 'Ensino Médio - Completo',
                                        '8' => 'Graduação - Incompleto',
                                        '9' => 'Graduação - Completo',
                                        '10' => 'Pós-Graduado',
                                        '11' => 'Mestrado',
                                        '12' => 'Doutorado',
                                    ]),
                                Forms\Components\DatePicker::make('data_nascimento')
                                    ->label('Data de Nascimento')
                                    ->required(false),
                                Forms\Components\TextInput::make('responsavel_nome')
                                    ->label('Nome do responsável')
                                    ->required(false)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('responsavel_grau'),
                                Forms\Components\TextInput::make('naturalidade')
                                    ->required(false)
                                    ->maxLength(255),
                                Radio::make('cor_raca')
                                    ->label('Cor/Raça:')
                                    ->inline()
                                    ->options([
                                        '1' => 'Branca',
                                        '2' => 'Preta',
                                        '3' => 'Parda',
                                        '4' => 'Amarela',
                                        '5' => 'Indígena',
                                        '6' => 'Não Declarar',
                                    ]),
                            ])->columnSpanFull(),
                        FileUpload::make('comprovante')
                            ->downloadable()
                            ->label('Anexar Comprovante'),
                    ]),
                Section::make('Análise da Inscrição')
                    ->description('Status')
                    ->schema([
                        Section::make()
                            ->schema([
                                Radio::make('inscricao_status')
                                    ->label('Situação da Inscrição')
                                    ->required(false)
                                    ->live()
                                    ->options([
                                        '1' => 'Em Análise',
                                        '2' => 'Efetivada',
                                        '3' => 'Não Efetivada',
                                    ])
                                    ->afterStateUpdated(function ($state, Inscricao $inscricao, $record) {
                                        if ($state == 2) {
                                            Mail::to($record->email)->send(new InscricaoStatus($inscricao));
                                        } elseif ($state == 3) {
                                            Mail::to($record->email)->send(new InscricaoRecusada($inscricao));
                                        }
                                    })
                                    ->default('1'),
                                Radio::make('aprovacao_status')
                                    ->label('Aprovação')
                                    ->required(false)
                                    ->live()
                                    ->options([
                                        '1' => 'Em Análise',
                                        '2' => 'Aprovado',
                                        '3' => 'Reprovado',
                                    ])
                                    ->default('1')
                                    ->afterStateUpdated(function (Get $get, Set $set, $record, Inscricao $inscricao) {
                                        if ($get('aprovacao_status') == 2) {
                                            $set('certificado_cod', random_int(1000000000, 9999999999));
                                            $set('certificado_data', Carbon::now()->format('d/m/Y'));
                                            Mail::to($record->email)->send(new CertificadoAprovadoParticipante($inscricao));
                                        }
                                        if ($get('aprovacao_status') <> 2) {
                                            $set('certificado_cod', '');
                                            $set('certificado_data', '');
                                        }
                                    }),
                                Forms\Components\TextInput::make('nota')
                                    ->required(false)
                                    ->maxLength(255),
                                Radio::make('motivo_reprovacao')
                                    ->label('Motivo da Reprovação')
                                    ->live()
                                    ->options([
                                        '1' => 'Falta',
                                        '2' => 'Não Aproveitamento',
                                        '3' => 'Desistência',
                                        '4' => 'Evasão',
                                    ])
                                    ->afterStateUpdated(function ($record, Inscricao $inscricao) {
                                        //  Mail::to($record->email)->send(new CertificadoNaoAprovadoParticipante($inscricao));
                                    }),
                                Forms\Components\TextInput::make('certificado_cod')
                                    ->label('Código do Certificado')
                                    ->readOnly(),
                                Forms\Components\TextInput::make('certificado_data')
                                    ->label('Data do Certificado')
                                    ->readOnly(),
                                Forms\Components\Textarea::make('obs')
                                    ->label('Observação')
                                    ->required(false)
                                    ->columnSpanFull(),
                            ])->columns(2)
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort('id', 'desc')
            ->groups([
                Group::make('acao.titulo')
                    ->label('Ação/Evento')
                    ->collapsible()
                    ->orderQueryUsing(fn(Builder $query, string $direction) => $query->orderBy('id', $direction)),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('Inscrição'),
                Tables\Columns\TextColumn::make('acao.titulo')
                    ->label('Evento/Ação'),
                Tables\Columns\TextColumn::make('inscricao_status')
                    ->Label('Status da Inscrição')
                    ->badge()
                    ->alignCenter()
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'warning',
                        '2' => 'success',
                        '3' => 'danger',
                    })
                    ->formatStateUsing(function ($state) {
                        if ($state == 1) {
                            return 'Em Análise';
                        }
                        if ($state == 2) {
                            return 'Aprovada';
                        }
                        if ($state == 3) {
                            return 'Recusada';
                        }
                    }),
                Tables\Columns\TextColumn::make('aprovacao_status')
                    ->Label('Status da Aprovação')
                    ->badge()
                    ->alignCenter()
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'warning',
                        '2' => 'success',
                        '3' => 'danger',
                    })
                    ->formatStateUsing(function ($state) {
                        if ($state == 1) {
                            return 'Em Análise';
                        }
                        if ($state == 2) {
                            return 'Aprovada';
                        }
                        if ($state == 3) {
                            return 'Recusada';
                        }
                    }),
                Tables\Columns\SelectColumn::make('inscricao_tipo')
                    ->label('Tipo de Inscrição')
                    ->disabled()
                    ->options([
                        '1' => 'Discente - IFPE - Campus Garanhuns',
                        '2' => 'Servidor - IFPE - Campus Garanhuns',
                        '3' => 'Externo - IFPE - Campus Garanhuns',
                    ]),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Servidor'),
                Tables\Columns\TextColumn::make('discente.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cpf')
                    ->searchable()
                    ->label('CPF'),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable()
                    ->label('Externo'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_nascimento')
                    ->searchable()
                    ->label('Data de Nascimento')
                    ->date(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('Inscrições em Análise')
                    ->query(fn(Builder $query): Builder => $query->where('inscricao_status', 1)),
                Filter::make('Inscrições em Aprovadas')
                    ->query(fn(Builder $query): Builder => $query->where('inscricao_status', 2)),
                SelectFilter::make('Evento/Ação')->relationship('acao', 'titulo'),
                Tables\Filters\Filter::make('data_inicio')
                    ->form([
                        Forms\Components\DatePicker::make('inicio_de')
                            ->label('Início de:'),
                        Forms\Components\DatePicker::make('inicio_ate')
                            ->label('Início até:'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['inicio_de'],
                                fn($query) => $query->whereDate('data_inicio', '>=', $data['inicio_de'])
                            )
                            ->when(
                                $data['inicio_ate'],
                                fn($query) => $query->whereDate('data_inicio', '<=', $data['inicio_ate'])
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Imprimir_certificdao')
                    ->label('Imprimir Certificado')
                    ->disabled(function ($record) {
                        if ($record->aprovacao_status == 2) {
                            return false;
                        } else {
                            return true;
                        }
                    })
                    ->url(fn(Inscricao $record): string => route('imprimirCertificadoParticipante', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInscricaos::route('/'),
            'create' => Pages\CreateInscricao::route('/create'),
            'edit' => Pages\EditInscricao::route('/{record}/edit'),
        ];
    }
}