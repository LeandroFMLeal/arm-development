<script>
    /**
     * Created by Renato on 11/08/16.
     */

    var apostaInicial = 1.0;

    var maximoApostado = 0;
    var currentAposta = apostaInicial;
    var verificarSaldo = true ;
    var saldoAtual = 1000.0;
    var saldoLimite = 850.0;
    var saldoInicial = saldoAtual;

    var apostaAtual = 0.0 ;
    //retorno da aposta caso acerte
    var roi = 1.85 ;
    //toggle
    var currentTentativa = 0;
    var totalDeTentativas = 0 ;

    var historicoDerrotaConsecutiva = 0 ;
    var totalDeTentativasConsecutivas = 0;
    var log = [];
    var poupanca = 0.0;
    function resetAposta(){
        currentAposta = apostaInicial;
    }
    function getCurrentAposta(){
        return currentAposta;
    }
    function resetAll(){
        resetAposta();
        saldoAtual = saldoInicial;
        maximoApostado = 0;
        totalDeTentativas = 0 ;
        log = [] ;
    }

    function saque(v){
        if(saldoAtual-v < 0){
            console.log("Não tem saldo para tanto saque");
            return;
        }
        poupanca += v ;
        saldoAtual -= v;
    }


    function autoSetNextAposta(){
        currentAposta = [1,3,8,18,40,88,191,420,950,2100,4650][totalDeTentativasConsecutivas]*1.0;
        if(totalDeTentativasConsecutivas >= 6 || (saldoAtual-currentAposta) < saldoLimite ) {
            //segurando a onda parça
            totalDeTentativasConsecutivas = 1;
        }
        return;
        //novo
        currentAposta = historicoDerrotaConsecutiva+totalDeTentativasConsecutivas+currentAposta;
        return;
        //antigo
        currentAposta = currentAposta*2.8; return currentAposta;
    }
    function pay(v){
        saldoAtual += v ;
    }
    function miniLog(){
        console.table([{saldo:saldoAtual, poupanca:poupanca}]);
    }
    function facaAposta(v){
        //verificando saldo
        if(verificarSaldo){
            if( saldoAtual - v < 0 ){
                console.log('você está sem saldo | MAXIMO: '+maximoApostado);
                if(poupanca >= saldoInicial){
                    saque(saldoAtual);
                    //devolvendo 1000 pra aplicar:: Transferindo e continuando a vida
                    if(poupanca - saldoInicial > 0){
                        poupanca -= saldoInicial ;
                        saldoAtual += saldoInicial ;
                        currentAposta = 1;
                        v = 1;
                        apostaAtual = v ;
                        saldoAtual -= v;
                        return true;
                    }
                }
                return false;
            }
        }
        apostaAtual = v ;
        saldoAtual -= v;
        return true ;
    }

    function getNextTentativa(){ currentTentativa = Math.abs(--currentTentativa); return (currentTentativa == 0)?true:false; }

    function sorteio(){ return Math.round((Math.random()%2)*100)%2==0; }
    //joga automático conforme o algorítimo
    function joga(comLog){
        console.log(" TENTATIVA: "+totalDeTentativas);
        if(saldoAtual > saldoInicial*1.1){
            //sacando 10%
            saque( saldoInicial );
        }
        var aposta = getCurrentAposta() ;
        var logInfo  = {
            id:totalDeTentativas,
            aposta: aposta,
            valorGanho:0,
            saldoInicial:saldoAtual*1,
            saldoFinal:saldoAtual*1,
            totalDerrotaConsecutivas:0,
            maximoApostado:maximoApostado,
            poupanca: poupanca
        };
        var result = facaAposta(aposta) ;
        //seta o máximo apostado só pra saber
        if(result){
            //TEM SALDO
            if(aposta > maximoApostado) maximoApostado = aposta ;
            totalDeTentativas++ ;
            //está apostado, ver se ganhou
            var tentativa = getNextTentativa() ;
            var sorteado = sorteio() ;
            if(comLog) console.log("Foi sorteado "+sorteado+ " e vc apostou "+currentAposta+" que daria "+tentativa) ;
            if( sorteado == tentativa ){
                totalDeTentativasConsecutivas = 0;
                valorGanho = currentAposta*roi ;
                pay(valorGanho);
                if(comLog) console.log("VOCÊ GANHOU "+valorGanho+" !!!! SALDO: "+saldoAtual+" | MAXIMO: "+maximoApostado);
                logInfo.valorGanho = valorGanho;
                logInfo.saldoFinal = saldoAtual;
                //como ganhou reseta a tentaiva
                log.push(logInfo);
                if(comLog) showLog();
                resetAposta();
                return;
            }
            totalDeTentativasConsecutivas++;
            historicoDerrotaConsecutiva += aposta;
            if(comLog) console.log("PERDEU!!! SALDO: "+saldoAtual+" | MAXIMO: "+maximoApostado);
            logInfo.totalDerrotaConsecutivas = totalDeTentativasConsecutivas ;
            logInfo.saldoFinal = saldoAtual;
            log.push(logInfo);
            //aqui perdeu.
            autoSetNextAposta() ;
            if(comLog) showLog();
        }
    }
    function showLog(){
        console.table(log);
    }

    function autoJoga(quant){
        var comLog = false ;
        for(var i = 0; i < quant; i++){
            comLog = (i>= quant-1);
            joga(comLog);
        }
    }

</script>
<button onclick="autoJoga(20)">Auto joga 20</button>
<button onclick="miniLog()">MiniLog</button>
<?php
