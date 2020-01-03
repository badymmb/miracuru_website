<?php include_once("template/includes/header.php"); ?>

<?php
    
    require_once("./src/repositories/ShopRepository.php");

    $shopRepository = new ShopRepository();

    $items = $shopRepository->getAllItems();

?>

<div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="session-block mt-3">
            <section class="row loja">

                <div class="col-12">
                    <p class="text-white">Atenção, agora a sistemática da loja mudou. A cada <strong>R$ 1,00</strong> você consegue comprar <strong>3 pontos</strong>, e abaixo segue listagem dos itens com a quantidade de pontos necessárias para trocar no VIP Seller, além dos botões com as opções de compra de pontos!</p>

                    <p class="text-white">
                        Para sua segurança e deposito correto dos pontos, necessitamos que confirme as seguintes informações através do nosso email <a class="text-danger" href="mailto:miracuruofthetime@gmail.com">miracuruofthetime@gmail.com</a>, e/ou através de uma mensagem em nossa página do facebook (<a class="text-danger" href="https://fb.me/miracuruofthetime" target="_BLANK">Miracuru Of The Time</a>).
                    </p>
                    <ul class="ml-3 text-white">
                        <li>Email de pagamento;</li>
                        <li>4 (Quatro) últimos digitos do cartão ou código de barras do boleto;</li>
                        <li>Código de ordem/identificação gerado após confirmação do pagamento;</li>
                        <li>Nome do character no qual encontra-se a conta para deposito dos pontos.</li>
                    </ul>
                    <p class="text-danger">Atenção, os pontos somente serão creditados após confirmação do pagamento: cartão de crédito (Estima-se que seja imediato desde que as informações estejam corretas), boleto bancário (3 dias úteis para confirmação).</p>
                    <br />
                    <p class="text-white">Para pagamento por depósito, pode utilizar a conta abaixo:</p>
                    <ul class="ml-3 text-white">
			<li><strong>Banco do Brasil</strong></li>
                        <li><strong>Agência: </strong>3657-9</li>
                        <!-- <li><strong>Operação: </strong></li> -->
                        <li><strong>Conta: </strong>22354-9</li>
                        <li><strong>Nome: </strong>Ricardo Nunes Leal Filho</li>
                    </ul>
                    <p class="text-white">Necessário envio das informações abaixo referente ao depósito, através do nosso email <a class="text-danger" href="mailto:miracuruofthetime@gmail.com">miracuruofthetime@gmail.com</a>, e/ou através de uma mensagem em nossa página do facebook (<a class="text-danger" href="https://fb.me/miracuruofthetime" target="_BLANK">Miracuru Of The Time</a>).</p>
                    <ul class="ml-3 text-white">
                        <li>Comprovante de deposito;</li>
                        <li>Nome do character no qual encontra-se a conta para deposito dos pontos.</li>
                    </ul>
                </div>

            </section>
            
            <section class="row loja">
            <?php
    
            foreach($items as $item){
                ?>
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3 mt-3">
                        <div class="card">
                            <div class="w-100 text-center mt-2">
                                <img src="./public/images/<?php echo $item->img ?>" class="card-img-top" alt="<?php echo $item->title ?>">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item->title ?></h5>
                                <p class="card-text"><?php echo $item->description ?></p>
                                <p class="card-text card-text-money"><?php echo $item->price ?></p>
                            </div>
                            <div class="w-100 mt-2 mb-2 d-flex justify-content-center">
                                <a class="btn btn-success w-50" target="_BLANK" href="<?php echo $item->linkPag ?>">Comprar</a>
                            </div>
                        </div>
                    </div>
                <?php
            }
        ?>
            </section>
        </div>
    </div>
</div>

<?php include_once("template/includes/footer.php"); ?>