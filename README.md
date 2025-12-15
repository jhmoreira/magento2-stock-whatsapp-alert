# Stock WhatsApp Alert - Módulo Magento 2
Módulo Magento 2 que permite o envio manual de alertas via WhatsApp com base na situação atual dos produtos

## Descrição
Este módulo permite que o administrador da loja gere e envie, sob demanda, um relatório de produtos com estoque baixo diretamente pelo WhatsApp. A verificação do estoque acontece no momento do envio, garantindo que as informações estejam sempre atualizadas
## Funcionalidades
Geração de relatório de produtos com estoque abaixo do minimo configurado
Verificação dinâmica do estoque no momento do envio
Preparação automática da mensagem para envio via WhatsApp
Integração com painel adminstrativo do Magento 2
Envio manual sob demanda do lojista

## Utilização
Copie o módulo para app/code/Moreira/LowStock

Rode os seguintes comandos
bin/magento module:enable Moreira_LowStock
bin/magento setup:upgrade
bin/magento setup:di:compile

Acesse o painel do Magento
Vá em:
Stores -> Configuration -> General -> Estoque Minimo
Preenche as configurações do módulo

Para enviar o relatório acesse:
Content -> LowStock -> Enviar relatório para WhatsApp
