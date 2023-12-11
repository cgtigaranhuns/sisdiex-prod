<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcaoResource\Pages;
use App\Filament\Resources\AcaoResource\RelationManagers;
use App\Filament\Resources\AcaoResource\RelationManagers\ConteudoProgramaticoRelationManager;
use App\Models\User;
use App\Models\Acao;
use App\Models\Area;
use App\Models\TipoAcao;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;


class AcaoResource extends Resource
{
    protected static ?string $model = Acao::class;

    protected static ?string $navigationIcon = 'heroicon-m-pencil-square';

    protected static ?string $navigationGroup = 'Evento/Ação';

    protected static ?string $navigationLabel = 'Propostas';

    //
    //

    public static function getEloquentQuery(): Builder
    {
        /** @var \App\Models\User */
        $authUser =  auth()->user();

        if ($authUser->hasRole('Administrador')) {
            return parent::getEloquentQuery();
        } elseif (!$authUser->hasRole('Administrador')) {
            return parent::getEloquentQuery()->where('user_id', '=', auth()->user()->id);
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Cadastro da Ação')
                    ->description('Dados Básicos')
                    ->schema([
                        Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('titulo')
                                    ->label('Título')
                                    ->required(true)
                                    ->columnSpanFull()
                                    ->maxLength(255),


                                Forms\Components\Select::make('user_id')
                                    ->label('Proponente')
                                    ->required(true)
                                    ->native(false)
                                    ->default(auth()->user()->id)
                                    ->searchable()
                                    ->options(
                                        function () {
                                            /** @var \App\Models\User */
                                            $authUser =  auth()->user();

                                            if ($authUser->hasRole('Administrador')) {
                                                return User::all()->pluck('name', 'id')->toArray();
                                            } else {

                                                return User::where('id', auth()->user()->id)->pluck('name', 'id')->toArray();
                                            }
                                        }
                                    ),


                                Forms\Components\Select::make('area_conhecimento_id')
                                    ->preload()
                                    ->native(false)
                                    ->label('Área de Conhecimento')
                                    ->required(true)
                                    ->searchable()
                                    ->options(Area::where('tipo', 2)->pluck('nome', 'id')->toArray()),
                                Forms\Components\Select::make('area_tematica_id')
                                    ->native(false)
                                    ->label('Área Temática')
                                    ->searchable()
                                    ->required(true)
                                    ->options(Area::where('tipo', 3)->pluck('nome', 'id')->toArray()),
                                Forms\Components\Select::make('area_extensao_id')
                                    ->native(false)
                                    ->label('Área de Extensão')
                                    ->searchable()
                                    ->required(true)
                                    ->options(Area::where('tipo', 1)->pluck('nome', 'id')->toArray()),
                                Forms\Components\Select::make('tipo_acao_id')
                                    ->native(false)
                                    ->label('Tipo de Ação')
                                    ->searchable()
                                    ->required(true)
                                    ->options(TipoAcao::all()->pluck('nome', 'id')->toArray()),
                                Forms\Components\Radio::make('atividade_relativa')
                                    ->label('Atividade Relativa')
                                    ->required(true)
                                    ->options([
                                        '1' => 'Ensino',
                                        '2' => 'Pesquisa',
                                        '3' => 'Extensão',
                                    ]),
                                Forms\Components\TextInput::make('publico_alvo')
                                    ->label('Público Alvo')
                                    ->required(true)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('vagas_total')
                                    ->label('Total de Vagas')
                                    ->required(true),
                                Forms\Components\TextInput::make('vagas_externa')
                                    ->label('Vagas Externas')
                                    ->hint('Sugerimos que pelo menos 20% das vagas sejam ofertadas ao público externo.')
                                    ->required(true),
                                Forms\Components\TextInput::make('local')
                                    ->required(true)
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('data_inicio')
                                    ->label('Data Início')
                                    ->closeOnDateSelection()
                                    ->required(true),
                                Forms\Components\DatePicker::make('data_encerramento')
                                    ->label('Data Encerramento')
                                    ->closeOnDateSelection()
                                    ->required(true),
                                Forms\Components\TimePicker::make('hora_inicio')
                                    ->label('Hora Início')
                                    ->seconds(false)
                                    ->required(true),
                                Forms\Components\TimePicker::make('hora_encerramento')
                                    ->label('Hora Encerramento')
                                    ->seconds(false)
                                    ->required(true),


                                Forms\Components\TextInput::make('carga_hr_semanal')
                                    ->placeholder('HH:mm')
                                    ->label('Carga Horária Semanal')
                                    ->mask('99:99')
                                    ->required(true),
                                Forms\Components\TextInput::make('carga_hr_total')
                                    ->placeholder('HH:mm')
                                    ->label('Carga Horária Total')
                                    ->mask('99:99')
                                    ->required(true),
                                Fieldset::make('Período')
                                    ->schema([
                                        Grid::make([
                                            'sm' => 2,
                                            'xl' => 5,
                                        ])

                                            ->schema([
                                                Forms\Components\CheckboxList::make('dias_semana')
                                                    ->label('Dias da Semana')
                                                    ->options([
                                                        '1' => 'Segunda-Feira',
                                                        '2' => 'Terça-Feira',
                                                        '3' => 'Quarta-Feira',
                                                        '4' => 'Quinta-Feira',
                                                        '5' => 'Sexta-Feira',
                                                        '6' => 'Sábado',
                                                        '7' => 'Domingo',
                                                    ])
                                                    ->required(true),
                                                Forms\Components\Radio::make('periocidade')
                                                    ->required(true)
                                                    ->options([
                                                        '1' => 'Mensal',
                                                        '2' => 'Trimestral',
                                                        '3' => 'Semestral/Anual',
                                                    ]),
                                                Forms\Components\Radio::make('modalidade')
                                                    ->required(true)
                                                    ->options([
                                                        '1' => 'Presencial',
                                                        '2' => 'EAD',
                                                        '3' => 'Semipresencial',
                                                    ]),
                                                Forms\Components\Radio::make('turno')
                                                    ->required(true)
                                                    ->options([
                                                        '1' => 'Matutino',
                                                        '2' => 'Vespertino',
                                                        '3' => 'Noturno/Integral',
                                                    ]),
                                                Forms\Components\Radio::make('duracao_aula')
                                                    ->label('Duração da Aula')
                                                    ->required(true)
                                                    ->options([
                                                        '1' => '45 min',
                                                        '2' => '50 min',
                                                        '3' => '60 min',
                                                    ]),
                                            ])
                                    ])->columnSpanFull()
                            ])->columns(2),
                    ]),

                Fieldset::make()
                    ->schema([
                        Section::make('Cadastro da Ação')
                            ->description('Critérios de Avaliação')
                            ->schema([
                                Forms\Components\Select::make('criterio_aprovacao')
                                    ->options([
                                        '1' => 'Somente por frequência',
                                        '2' => 'Somente por nota',
                                        '3' => 'Frequência e nota',

                                    ])
                                    ->label('Críterio de Aprovação')
                                    ->native(false)
                                    ->required(true),

                                Forms\Components\Select::make('frequencia_minima')
                                    ->options([
                                        '1' => '70%',
                                        '2' => '75%',
                                        '3' => '80%',

                                    ])
                                    ->label('Frequência Mínima')
                                    ->required(true),

                                Forms\Components\Select::make('media_aprovacao')
                                    ->options([
                                        '1' => '6.0',
                                        '2' => '6.5',
                                        '3' => '7.0',

                                    ])
                                    ->label('Média de Aprovação')
                                    ->native(false)
                                    ->required(true),

                                Forms\Components\TextInput::make('forma_avaliacao')
                                    ->label('Forma de Avaliação')
                                    ->required(true)
                                    ->maxLength(255),
                            ])->columns(2),
                    ]),
                Fieldset::make()
                    ->schema([
                        Section::make('Cadastro da Ação')
                            ->description('Demais Informações')
                            ->schema([
                                Forms\Components\Textarea::make('requisitos')
                                    ->required(true),
                                Forms\Components\Textarea::make('justificativa')
                                    ->required(true),
                                Forms\Components\Textarea::make('objetivo_geral')
                                    ->label('Objetivo Geral')
                                    ->required(true),
                                Forms\Components\Textarea::make('objetivo_especifico')
                                    ->label('Objetivo Específicos')
                                    ->required(true),
                                Forms\Components\Textarea::make('metodologia')
                                    ->required(true),
                                Forms\Components\Textarea::make('bibliografia')
                                    ->required(true),
                                Forms\Components\Textarea::make('outras_informacoes')
                                    ->label('Outras Informações')
                                    ->columnSpan('full'),
                            ])->columns(2),

                        Fieldset::make('Aprovação da Ação/Evento')
                            ->hidden(
                                function () {
                                    /** @var \App\Models\User */
                                    $authUser =  auth()->user();

                                    if ($authUser->hasRole('Administrador')) {
                                        return false;
                                    } else {
                                        return true;
                                    }
                                }
                            )
                            ->schema([
                                Forms\Components\Radio::make('status')
                                    ->label('Situação da Proposta')
                                    ->live()
                                    ->options([
                                        '1' => 'Em Análise',
                                        '2' => 'Efetivada',
                                        '3' => 'Não Efetivada',
                                    ])
                                    ->default('1'),
                                Forms\Components\Textarea::make('status_justifique')
                                    ->columnSpan('2')
                                    ->label('Justificativa')
                                    ->hidden(fn (Get $get) => $get('status') != '3'),

                                Forms\Components\DatePicker::make('data_inicio_inscricoes')
                                    ->closeOnDateSelection()
                                    ->label('Início das Incrições')
                                    ->hidden(fn (Get $get) => $get('status') == '3'),
                                    
                                Forms\Components\DatePicker::make('data_fim_inscricoes')
                                    ->closeOnDateSelection()
                                    ->label('Encerramento das Incrições')
                                    ->hidden(fn (Get $get) => $get('status') == '3'),
                                    
                                Forms\Components\Radio::make('doacao')
                                    ->label('Doação')
                                    ->live()
                                    ->options([
                                        '1' => 'Sim',
                                        '2' => 'Não',

                                    ]),
                                Forms\Components\TextInput::make('tipo_doacao')
                                    ->hidden(fn (Get $get): bool => $get('doacao') === null || $get('doacao') === '2')
                                    ->label('Tipo de Doação')
                                    ->columnSpanFull()
                                    ->maxLength(255),
                                Forms\Components\Radio::make('cota')
                                    ->label('Cotas')
                                    ->columnSpanFull()
                                    ->live()
                                    ->options([
                                        '1' => 'Sim',
                                        '2' => 'Não',

                                    ]),
                                Forms\Components\TextInput::make('cota_servidor')
                                    ->hidden(fn (Get $get): bool => $get('cota') === null || $get('cota') === '2')
                                    ->label('Cota para Servidor')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('cota_discente')
                                    ->hidden(fn (Get $get): bool => $get('cota') === null || $get('cota') === '2')
                                    ->label('Cota para Discente')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('cota_externo')
                                    ->hidden(fn (Get $get): bool => $get('cota') === null || $get('cota') === '2')
                                    ->label('Cota para Externo')
                                    ->maxLength(255),



                            ])->columns(3)
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable()
                    ->label('Título'),
                /*   Tables\Columns\IconColumn::make('status')
                    ->alignCenter()
                   ->label('Status')
                    ->icon(fn (string $state): string => match ($state) {
                        '1' => 'heroicon-m-clock',
                        '2' => 'heroicon-m-check',
                        '3' => 'heroicon-m-trash',
                    }) 
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'warning',
                        '2' => 'success',
                        '3' => 'danger',
                    }),  */
                Tables\Columns\TextColumn::make('status')
                    ->Label('Status da Proposta')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'warning',
                        '2' => 'success',
                        '3' => 'danger',
                    })
                    ->formatStateUsing(function($state){
                        if($state == 1) {
                            return 'Em Análise';
                        }
                        if($state == 2) {
                            return 'Aprovada';
                        }
                        if($state == 3) {
                            return 'Recusada';
                        }
                    }),  

                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Proponente'),
                Tables\Columns\TextColumn::make('AreaConhecimento.nome')
                    ->label('Área de Conhecimento'),
                Tables\Columns\TextColumn::make('AreaTematica.nome')
                    ->label('Área Temática'),
                Tables\Columns\TextColumn::make('AreaExtensao.nome')
                    ->label('Área de Extensão'),
                Tables\Columns\TextColumn::make('TipoAcao.nome')
                    ->label('Tipo Ação'),
                Tables\Columns\SelectColumn::make('atividade_relativa')
                    ->label('Atividade Relativa')
                    ->options([
                        '1' => 'Ensino',
                        '2' => 'Pesquisa',
                        '3' => 'Extensão',
                    ]),
                Tables\Columns\TextColumn::make('publico_alvo')
                    ->label('Público Alvo'),
                Tables\Columns\TextColumn::make('vagas_total')
                    ->alignCenter()
                    ->label('Total de Vagas'),
                Tables\Columns\TextColumn::make('vagas_externa')
                    ->alignCenter()
                    ->label('Vagas Externas'),
                Tables\Columns\TextColumn::make('local'),
                Tables\Columns\TextColumn::make('data_inicio')
                    ->alignCenter()
                    ->label('Data Início')
                    ->date(),
                Tables\Columns\TextColumn::make('data_encerramento')
                    ->alignCenter()
                    ->label('Data Encerramento')
                    ->date(),
                Tables\Columns\TextColumn::make('hora_inicio')
                    ->alignCenter()
                    ->label('Hora Início'),
                Tables\Columns\TextColumn::make('hora_encerramento')
                    ->alignCenter()
                    ->label('Hora Encerramento'),
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
                Filter::make('Em Análise')
                    ->query(fn (Builder $query): Builder => $query->where('status', 1)),
                SelectFilter::make('proponente')->relationship('user', 'name'),
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
                                fn ($query) => $query->whereDate('data_inicio', '>=', $data['inicio_de'])
                            )
                            ->when(
                                $data['inicio_ate'],
                                fn ($query) => $query->whereDate('data_inicio', '<=', $data['inicio_ate'])
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('form_qacademico')
                    ->label('Q-Acadêmico')
                    ->hidden(function () {
                        /** @var \App\Models\User */
                        $authUser =  auth()->user();

                        if ($authUser->hasRole('Administrador')) {
                            return false;
                        } else {
                            return true;
                        }
                    })
                    ->url(fn (Acao $record): string => route('imprimirFormQacademico', $record))
                    ->openUrlInNewTab(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ConteudoProgramaticoRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcaos::route('/'),
            'create' => Pages\CreateAcao::route('/create'),
            'edit' => Pages\EditAcao::route('/{record}/edit'),
        ];
    }
}
