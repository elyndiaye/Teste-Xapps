<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html ng-app="teste">
    <head>
        <meta charset="UTF-8">
        <title>Teste</title>
        <link rel="stylesheet" type="text/css" href="lib/bootstrap/bootstrap.css">
        <style>
            .jumbotron{
                text-align: center;
                margin-top: 20px;
                margin-left: auto;
                margin-right: auto;
                background:#A7C0DC;
            }
            .table{margin-top: 20px;}
            .form-control{margin-bottom: 5px;}
            .selecionado{background-color:yellow;}
            .negrito{font-weight: bold;}
        </style>
        <script src="angular-1.5.8/angular.js"></script>
        <script src="lib/angular/angular-locale_pt-br.js"></script>
        <script>
            angular.module("teste", []);
            angular.module("teste").controller("testeCtrl", function ($scope, $filter) {
                $scope.message = "Testando";
                $scope.app = "Lista de Mercadoria";
                $scope.mercadorias = [
                    {cdMercadoria: "1", tipoMercadoria: "teste",data: new Date() , nmMercadoria: "Mercadoria", qtd: "2", preco: "10"},
                    {cdMercadoria: "2", tipoMercadoria: "teste2",data: new Date() , nmMercadoria: "Mercadoria2", qtd: "2", preco: "10"},
                    {cdMercadoria: "3", tipoMercadoria: "teste3",data: new Date() , nmMercadoria: "Mercadoria3", qtd: "3", preco: "10"}
                ];
                $scope.negocios = [
                    {tipo:"Compra"},
                    {tipo:"Venda"}
                ];
                $scope.adicionarMercadoria = function(mercadoria){
                    mercadoria.data = new Date();
                    $scope.mercadorias.push(angular.copy(mercadoria));
                    delete $scope.mercadoria;
                    $scope.mercadoriaForm.$setPristine();
                };
                $scope.apagarMercadorias = function(mercadorias){
                   $scope.mercadorias = mercadorias.filter(function(mercadoria){
                        if(!mercadoria.selecionado) return mercadoria;
                    });
                };
                $scope.isMercadoriaSelecionado = function (mercadorias){
                    return mercadorias.some(function(mercadoria){
                        return mercadoria.selecionado;
                    });
                };
                $scope.ordenarPor = function(campo){
                    $scope.criterioDeOrdenacao = campo;
                }
            });
        </script>
    </head>
    <body ng-controller="testeCtrl">   
        <div class="jumbotron">
            <h3> {{app}}</h3>
            <input class="form-control" type="text" ng-model="criterioDeBusca" placeholder="Busca na Lista"/>
            <table ng-show="mercadorias.length > 0" class="table table-striped">
                <tr>
                    <th></th>
                    <th>Código da Mercadoria</th>
                    <th>Tipo da Mercadoria</th>
                    <th><a href="" ng-click="ordenarPor('data')">Data</a></th>
                    <th><a href="" ng-click="ordenarPor('nmMercadoria')">Nome da Mercadoria<a/></th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Tipo de Negocio</th>
                </tr>
                <tr ng-class="{selecionado:mercadoria.selecionado, negrito:mercadoria.selecionado}" ng-repeat="mercadoria in mercadorias | filter:criterioDeBusca | orderBy:criterioDeOrdenacao:false">
                    <td><input type="checkbox" ng-model="mercadoria.selecionado"/></td>
                    <td>{{mercadoria.cdMercadoria}}</td>
                    <td>{{mercadoria.tipoMercadoria}}</td>
                    <td>{{mercadoria.data | date: 'dd/MM/yyyy' }}</td>
                    <td>{{mercadoria.nmMercadoria}}</td>
                    <td>{{mercadoria.qtd}}</td>
                    <td>{{mercadoria.preco}}</td>
                    <td>{{mercadoria.negocio.tipo}}</td>
                </tr>
            </table>
            <hr/>
            <form name="mercadoriaForm">
                <input class="form-control" type="text" ng-model="mercadoria.cdMercadoria" name="cdMercadoria" placeholder="Codigo da Mercadoria"ng-required="true" />
                <input class="form-control" type="text" ng-model="mercadoria.tipoMercadoria" name="tipo" placeholder="Tipo da Mercadoria"ng-required="true"/>
                <input class="form-control" type="text" ng-model="mercadoria.nmMercadoria" name="nome" placeholder="Nome da Mercadoria"ng-required="true"/>
                <input class="form-control" type="text" ng-model="mercadoria.qtd" name="qtd" placeholder="Quantidade"ng-required="true"/>
                <input class="form-control" type="text" ng-model="mercadoria.preco" name="preco" placeholder="Preço"ng-required="true"/>
                <select class="form-control" ng-model="mercadoria.negocio" name="negocio" ng-options="negocio.tipo for negocio in negocios" ng-required="true">
                    <option value="">Escolha o tipo de Negocio:</option>
                </select>
            </form>
            <div ng-show="mercadoriaForm.cdMercadoria.$invalid && mercadoriaForm.cdMercadoria.$dirty" class="alert alert-danger"> Por favor, preencha o codigo da Mercadoria </div>
            <div ng-show="mercadoriaForm.tipo.$invalid && mercadoriaForm.tipo.$dirty" class="alert alert-danger"> Por favor preencha o Tipo de Mercadoria !</div>
            <div ng-show="mercadoriaForm.nome.$invalid && mercadoriaForm.nome.$dirty" class="alert alert-danger"> Por favor preencha o nome da Mercadoria !</div>
            <div ng-show="mercadoriaForm.qtd.$invalid && mercadoriaForm.qtd.$dirty" class="alert alert-danger"> Por favor preencha a quantidade da Mercadoria !</div>
            <div ng-show="mercadoriaForm.preco.$invalid && mercadoriaForm.preco.$dirty" class="alert alert-danger"> Por favor preencha o preço da Mercadoria !</div>
            <div ng-show="mercadoriaForm.negocio.$invalid && mercadoriaForm.negocio.$dirty" class="alert alert-danger"> Por favor selecione o tipo de negocio da Mercadoria !</div>
            <button class="btn btn-primary" ng-click="adicionarMercadoria(mercadoria)" ng-disabled="mercadoriaForm.$invalid">Adicionar Mercadoria</button>
            <button class="btn btn-danger" ng-click="apagarMercadorias(mercadorias)" ng-show="isMercadoriaSelecionado(mercadorias)">Apagar Mercadorias</button>
            {{mercadoria}}    
        </div>

        <?php
        // put your code here
        ?>
    </body>
</html>
