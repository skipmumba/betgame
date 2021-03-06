<?php
    namespace Simplon\Payment\Skrill\PaymentMethods;

    class SkrillPaymentMethodsEstonia extends SkrillPaymentMethodsAllCountries
    {
        /**
         * @return $this
         */
        public function useBankOnlineBankTransfer()
        {
            $this->_addEnabledMethodCode(AbstractSkrillPaymentMethods::BANK_ONLINE_BANK_TRANSFER);

            return $this;
        }
    }
