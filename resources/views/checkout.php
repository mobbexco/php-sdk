<script src="https://res.mobbex.com/js/embed/mobbex.embed@1.0.8.js" integrity="sha384-mkzSVPypRrC9BsOY8dTk16RcTIY8X654RJI4CDOriI+Ir3PtWcgvhsnYivJ3dxnz" crossorigin="anonymous"></script>
<script>
    var options = {
        id: "{ID Checkout}",
        type: "checkout",
        onResult: (data) => {
            // OnResult es llamado cuando se toca el Botón Cerrar
            window.MobbexEmbed.close();
        },
        onPayment: (data) => {
            console.info("Payment: ", data);
        },
        onOpen: () => {
            console.info("Pago iniciado.");
        },
        onClose: (cancelled) => {
            console.info(`${cancelled ? "Cancelado" : "Cerrado"}`);
        },
        onError: (error) => {
            console.error("ERROR: ", error);
        },
    };
</script>

<div id="mbbx-button"></div>
<?php
