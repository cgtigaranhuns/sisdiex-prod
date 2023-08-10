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
                                                    
        if($authUser->hasRole('Proponente'))
        {

            return parent::getEloquentQuery()->where('user_id','=', auth()->user()->id);
        }
        elseif($authUser->hasRole('Administrador'))
        {
            return parent::getEloquentQuery(); 
        }
    } 

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Cadastro da Ação')
                ->description('Dados Básicos')
                ->schema([
                        Card::make()
                        ->schema([
                                Forms\Components\TextInput::make('titulo')
                                    ->label('Título')
                                    ->required(false)
                                    ->columnSpanFull()
                                    ->maxLength(255),

                            
                                        Forms\Components\Select::make('user_id')
                                            ->label('Proponente')
                                            ->required(false)
                                            ->searchable()
                                            ->options(function () {
                                                    /** @var \App\Models\User */
                                                    $authUser =  auth()->user();
                                                    
                                                    if($authUser->hasRole('Administrador'))
                                                    {
                                                       return User::all()->pluck('name', 'id')->toArray();
                                                    }
                                                    elseif($authUser->hasRole('Proponente')) 
                                                    {
                                                        
                                                       return User::where('id',auth()->user()->id)->pluck('name', 'id')->toArray();
                                                    }  

                                                    
                                               }
                                            ),
                                
                                                  
                                Forms\Components\Select::make('area_conhecimento_id')
                                    ->label('Área de Conhecimento')
                                    ->required(false)
                                    ->searchable()
                                    ->options(Area::where('tipo', 2)->pluck('nome', 'id')->toArray()),
                                Forms\Components\Select::make('area_tematica_id')
                                    ->label('Área Temática')
                                    ->searchable()
                                    ->required(false)
                                    ->options(Area::where('tipo', 3)->pluck('nome', 'id')->toArray()),
                                Forms\Components\Select::make('area_extensao_id')
                                    ->label('Área de Extensão')
                                    ->searchable()
                                    ->required(false)
                                    ->options(Area::where('tipo', 1)->pluck('nome', 'id')->toArray()),
                                Forms\Components\Select::make('tipo_acao_id')
                                    ->label('Tipo de Ação')
                                    ->searchable()
                                    ->required(false)
                                    ->options(TipoAcao::all()->pluck('nome', 'id')->toArray()),
                                Forms\Components\Radio::make('atividade_relativa')
                                    ->label('Atividade Relativa')
                                    ->required(false)
                                    ->options([
                                        '1' => 'Ensino',
                                        '2' => 'Pesquisa',
                                        '3' => 'Extensão',
                                    ]),
                                Forms\Components\TextInput::make('publico_alvo')
                                    ->label('Público Alvo')
                                    ->required(false)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('vagas_total')
                                    ->label('Total de Vagas')
                                    ->required(false),
                                Forms\Components\TextInput::make('vagas_externa')
                                    ->label('Vagas Externas')
                                    ->hint('Sugerimos que pelo menos 20% das vagas sejam ofertadas ao público externo.')
                                    ->required(false),
                                Forms\Components\TextInput::make('local')
                                    ->required(false)
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('data_inicio')
                                    ->label('Data Início')
                                    ->closeOnDateSelection()
                                    ->required(false),
                                Forms\Components\DatePicker::make('data_encerramento')
                                    ->label('Data Encerramento')
                                    ->closeOnDateSelection()
                                    ->required(false),
                                Forms\Components\TimePicker::make('hora_inicio')
                                    ->label('Hora Início')
                                    ->seconds(false)
                                    ->required(false),
                                Forms\Components\TimePicker::make('hora_encerramento')
                                    ->label('Hora Encerramento')
                                    ->seconds(false)
                                    ->required(false),
                                
                                    
                                Forms\Components\TextInput::make('carga_hr_semanal')
                                    ->label('Carga Horária Semanal')
                                    ->mask('99:99')
                                    ->required(false),
                                Forms\Components\TextInput::make('carga_hr_total')
                                    ->label('Carga Horária Total')
                                    ->mask('99:99')
                                    ->required(false),
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
                                            ->required(false),
                                            Forms\Components\Radio::make('periocidade')
                                                        ->required(false)
                                                        ->options([
                                                            '1' => 'Mensal',
                                                            '2' => 'Trimestral',
                                                            '3' => 'Semestral/Anual',
                                                        ]),
                                            Forms\Components\Radio::make('modalidade')
                                                        ->required(false)
                                                        ->options([
                                                            '1' => 'Presencial',
                                                            '2' => 'EAD',
                                                            '3' => 'Semipresencial',
                                                        ]),
                                            Forms\Components\Radio::make('turno')
                                                        ->required(false)
                                                        ->options([
                                                            '1' => 'Matutino',
                                                            '2' => 'Vespertino',
                                                            '3' => 'Noturno/Integral',
                                                        ]),
                                            Forms\Components\Radio::make('duracao_aula')
                                                        ->label('Duração da Aula')
                                                        ->required(false)
                                                        ->options([
                                                            '1' => '45 min',
                                                            '2' => '50 min',
                                                            '3' => '60 min',
                                                        ]), 
                                        ])
                            ])->columnSpanFull()
                        ])->columns(2),
                    ]),
            
            Card::make()
                ->schema([
                    Section::make('Cadastro da Ação')
                        ->description('Critérios de Avaliação')
                         ->schema([
                                Forms\Components\TextInput::make('criterio_aprovacao')
                                    ->label('Críterio de Aprovação')
                                    ->required(false)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('frequencia_minima')
                                    ->label('Frequência Mínima')
                                    ->required(false)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('media_aprovacao')
                                    ->label('Média de Aprovação')
                                    ->required(false)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('forma_avaliacao')
                                    ->label('Forma de Avaliação')
                                    ->required(false)
                                    ->maxLength(255),
                         ])->columns(2),
            ]),
            Card::make()
                ->schema([
                    Section::make('Cadastro da Ação')
                        ->description('Demais Informações')
                         ->schema([
                                Forms\Components\Textarea::make('requisitos')
                                    ->required(false),
                                Forms\Components\Textarea::make('justificativa')
                                    ->required(false),
                                Forms\Components\Textarea::make('objetivo_geral')
                                    ->label('Objetivo Geral')
                                    ->required(false),
                                Forms\Components\Textarea::make('objetivo_especifico')
                                    ->label('Objetivo Específicos')
                                    ->required(false),
                                Forms\Components\Textarea::make('motodologia')
                                    ->required(false),
                                Forms\Components\Textarea::make('bibliografia')
                                    ->required(false),
                                Forms\Components\Textarea::make('outras_informacoes')
                                    ->label('Outras Informações')
                                    ->required(false)
                                    ->columnSpan('full'), 
                        ])->columns(2), 

                        Fieldset::make('Aprovação da Ação/Evento')
                                ->hidden(function () {
                                    /** @var \App\Models\User */
                                    $authUser =  auth()->user();
                                    
                                    if($authUser->hasRole('Administrador'))
                                    {
                                       return false;
                                    }
                                    else 
                                    {
                                       return true;
                                    }  
                                 }
                             )
                            ->schema([
                                    Forms\Components\Radio::make('status')
                                                        ->label('Situação da Proposta')
                                                        ->required(false)
                                                        ->options([
                                                            '1' => 'Em Análise',
                                                            '2' => 'Efetivada',
                                                            '3' => 'Não Efetivada',
                                                        ])
                                                        ->default('1'),
                                    Forms\Components\DatePicker::make('data_inicio_inscricoes')
                                                       ->closeOnDateSelection()
                                                        ->label('Início das Incrições')
                                                        ->required(false),
                                    Forms\Components\DatePicker::make('data_fim_inscricoes')
                                                        ->closeOnDateSelection()
                                                        ->label('Encerramento das Incrições')
                                                        ->required(false),
                                    Forms\Components\Radio::make('doacao')
                                                        ->label('Doação')
                                                      //  ->columnSpanFull()
                                                        ->required(false)
                                                        ->options([
                                                            '1' => 'Sim',
                                                            '2' => 'Não',
                                                            
                                                        ]),
                                    Forms\Components\TextInput::make('tipo_doacao')
                                                        ->label('Tipo de Doação')
                                                        ->columnSpanFull()
                                                         ->required(false)
                                                        ->maxLength(255),
                                    Forms\Components\Radio::make('cota')
                                                        ->label('Cotas')
                                                        ->columnSpanFull()
                                                        ->required(false)
                                                        ->options([
                                                            '1' => 'Sim',
                                                            '2' => 'Não',
                                                            
                                                        ]),
                                    Forms\Components\TextInput::make('cota_servidor')
                                                        ->label('Cota para Servidor')
                                                        ->required(false)
                                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('cota_discente')
                                                        ->label('Cota para Discente')
                                                        ->required(false)
                                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('cota_externo')
                                                        ->label('Cota para Externo')
                                                        ->required(false)
                                                        ->maxLength(255),
                                    
                                    
                
                                    ])->columns(3)
                            ])

                       ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable()
                    ->label('Título'),
                Tables\Columns\IconColumn::make('status')
                    ->alignCenter()
                    ->label('Inscrição')
                    ->icon(fn (string $state): string => match ($state) {
                        '1' => 'heroicon-m-clock',
                        '2' => 'heroicon-m-check',
                        '3' => 'heroicon-m-trash',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'warning',
                        '2' => 'success',
                        '3' => 'danger',
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
                ->query(fn (Builder $query): Builder => $query->where('status', false)),
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
                            ->when($data['inicio_de'],
                                fn($query) => $query->whereDate('data_inicio', '>=', $data['inicio_de']))
                            ->when($data['inicio_ate'],
                                fn($query) => $query->whereDate('data_inicio', '<=', $data['inicio_ate']));
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
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
