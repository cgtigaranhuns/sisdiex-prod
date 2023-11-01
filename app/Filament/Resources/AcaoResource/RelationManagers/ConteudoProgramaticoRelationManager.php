<?php

namespace App\Filament\Resources\AcaoResource\RelationManagers;

use App\Models\Acao;
use App\Models\ConteudoProgramatico;
use Carbon\Carbon;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Livewire\before;

class ConteudoProgramaticoRelationManager extends RelationManager
{
    protected static string $relationship = 'ConteudoProgramatico';

    protected static ?string $recordTitleAttribute = 'acao_id';

    protected static ?string $title = 'Conteúdo Programático'; 


    

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ministrante')
                    ->label('Ministrante')
                    ->required(true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('cpf')
                    ->mask('999.999.999-99')
                    ->label('CPF'), 
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->required(true)
                    ->email(),
                Forms\Components\DatePicker::make('data_inicio')
                    ->label('Data Início')
                    ->required(true),
                Forms\Components\DatePicker::make('data_termino')
                    ->label('Data Término')
                    ->required(true),
                Forms\Components\TextInput::make('carga_horaria')
                    ->placeholder('HH:mm')
                    ->mask('99:99')   
                    ->label('Carga Horária')
                    ->required(true),
                Forms\Components\Textarea::make('ementa')
                    ->label('Ementa')
                    ->required(true)
                    ->columnSpan('full'), 
                Forms\Components\Toggle::make('certificado_status')
                    ->label('Liberar Certificado')
                    ->reactive()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                                                                                               
                        if($get('certificado_status') == 1) {
                           // dd('teste1');
                            $set('certificado_cod', random_int(1000000000, 9999999999));

                            $set('certificado_data', Carbon::now()->format('d/m/Y'));
                        } 
                        if($get('certificado_status') == 0) {
                          //  dd('teste2');
                            $set('certificado_cod', '');
                            $set('certificado_data', '');
                        } 
                    })
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
                     })
                    ->required(false),
                    Forms\Components\TextInput::make('certificado_cod')
                        ->label('Código do Certificado')
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
                         })
                        ->readOnly(),
                    Forms\Components\TextInput::make('certificado_data')
                        ->label('Data do Certificado')
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
                         })
                        ->readOnly(),

                    
                
                    
                
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            
            ->columns([
                 Tables\Columns\TextColumn::make('ministrante'),
                 Tables\Columns\TextColumn::make('cpf')
                    ->label('CPF'),
                 Tables\Columns\TextColumn::make('email'),
                 Tables\Columns\TextColumn::make('ementa')
                    ->limit(50),
                 Tables\Columns\TextColumn::make('data_inicio')
                    ->label('Data Início')
                    ->date(),
                 Tables\Columns\TextColumn::make('data_termino')
                    ->label('Data Término')
                    ->date(),
                 Tables\Columns\TextColumn::make('carga_horaria')
                    ->label('Carga Horária'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Novo'),
                    
                    
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('imprimir_certificdao')
                        ->label('Imprimir Certificado')
                        ->disabled(function ($record) {
                            if($record->certificado_status == 1) {
                                return false;
                            } else {
                                return true;
                            }
                        })
                        ->url(fn (ConteudoProgramatico $record): string => route('imprimirCertificadoMinistrante', $record))
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
}
