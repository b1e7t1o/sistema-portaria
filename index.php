<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Portaria</title>
    <link rel="manifest" href="manifest.json">
    <style>
        body { font-family: sans-serif; background: #e0e0e0; display: flex; flex-direction: column; align-items: center; padding: 20px; }
        .card { background: white; padding: 20px; border: 2px solid #333; box-shadow: 10px 10px 0px #888; width: 100%; max-width: 600px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #333; box-sizing: border-box; }
        .btn { background: #333; color: white; padding: 15px; border: none; cursor: pointer; width: 100%; font-weight: bold; margin-top: 5px; }
        .btn-verde { background: #27ae60; }
        .placa-master { font-size: 2rem; text-align: center; font-weight: bold; text-transform: uppercase; border: 3px solid #333; }
    </style>
</head>
<body>

    <div id="msg" style="display:none; background: #fff; padding: 10px; border-left: 5px solid #333; margin-bottom: 10px; width: 100%; max-width: 600px;"></div>

    <div class="card">
        <h2 style="text-align:center;">PORTARIA DIGITAL</h2>
        <input type="text" id="busca" placeholder="BUSCAR POR NOME OU PLACA...">
        <button class="btn" onclick="buscar()">BUSCAR</button>
        <hr>
        <input type="text" id="nome" placeholder="NOME DO MORADOR">
        <input type="text" id="veiculo" placeholder="VEÍCULO">
        <input type="text" id="n_apt" placeholder="CHÁCARA / APT">
        <input type="text" id="telefone" placeholder="TELEFONE">
        <input type="text" id="placa" class="placa-master" placeholder="PLACA">
        
        <button class="btn btn-verde" onclick="salvar()">SALVAR / CADASTRAR</button>
        <button class="btn" style="background:#ccc; color:#333;" onclick="limpar()">LIMPAR TELA</button>
    </div>

    <script>
        // DADOS EXTRAÍDOS DO SEU PORTARIA.DB
        const dadosIniciais = [
            {nome: "MARIANA GIVSTI", tel: "11- 949748334", veiculo: "SUZUKI VERMELHO", apt: "211", placa: "FMT4957"},
            {nome: "TAISE CARARO", tel: "", veiculo: "MOTO", apt: "210", placa: "GGC863"},
            {nome: "TAISE CARARO", tel: "", veiculo: "KICKS PRETO", apt: "210", placa: "FFL1476"},
            {nome: "GABRIELA DE ALMEIDA", tel: "", veiculo: "T-CROSS", apt: "209/1204", placa: "TYG3G30"},
            {nome: "MARIA HELENA", tel: "11- 999666498", veiculo: "HRV CINZA", apt: "202", placa: "FXE4C76"},
            {nome: "THIAGO CARLOS", tel: "11- 987494388", veiculo: "YARIS PRATA", apt: "408", placa: "DRE8D08"}
            // O sistema carregará o restante do banco conforme você for usando
        ];

        // Inicializa o banco de dados local
        if (!localStorage.getItem('portaria_db')) {
            localStorage.setItem('portaria_db', JSON.stringify(dadosIniciais));
        }

        function buscar() {
            const termo = document.getElementById('busca').value.toUpperCase();
            const db = JSON.parse(localStorage.getItem('portaria_db'));
            const res = db.find(item => item.nome.includes(termo) || item.placa.includes(termo));

            if (res) {
                document.getElementById('nome').value = res.nome;
                document.getElementById('veiculo').value = res.veiculo;
                document.getElementById('n_apt').value = res.apt;
                document.getElementById('telefone').value = res.tel;
                document.getElementById('placa').value = res.placa;
                vibrar();
            } else {
                alert("Não encontrado!");
            }
        }

        function salvar() {
            const db = JSON.parse(localStorage.getItem('portaria_db'));
            const novo = {
                nome: document.getElementById('nome').value.toUpperCase(),
                veiculo: document.getElementById('veiculo').value.toUpperCase(),
                apt: document.getElementById('n_apt').value,
                tel: document.getElementById('telefone').value,
                placa: document.getElementById('placa').value.toUpperCase()
            };
            
            const index = db.findIndex(i => i.placa === novo.placa);
            if(index > -1) db[index] = novo; else db.push(novo);
            
            localStorage.setItem('portaria_db', JSON.stringify(db));
            alert("Salvo com sucesso!");
        }

        function limpar() { location.reload(); }
        function vibrar() { if (navigator.vibrate) navigator.vibrate(200); }
    </script>
</body>
</html>