@extends('basecore::layout.main')

@section('content')

    <style>
        @page {
            size: 1400px 1980px !important;
            /* this affects the margin in the printer settings */
            margin: 0px 0px 0px 0px;
        }

        @media print {

            html, body{
                background: white!important;
            }

            .print-col-span-3 {
                grid-column: span 3 / span 3 !important;
            }

            .notcut {
                position: relative;
                break-inside: avoid;
                page-break-inside: avoid;
                -webkit-region-break-inside: avoid;
            }


            body, .invoice-content {
                position: relative;
                max-width: 100% !important;
                width: 100% !important;
                margin: 0;
            }

            .container, .row {
                padding: 0px;
                width: 100% !important;
                max-width: 100% !important;
            }

            .no-print {
                display: none;
            }

            .footer{
                background: white;
                color: gray;
            }

        }
    </style>

    <div class="pt-8 bg-white p-4">
        <div class="text-center underline mb-4">MENTIONS LEGALES ET POLITIQUE DE CONFIDENTIALITE DU SITE CENTRALE
            AUTOCAR
        </div>
        <div class="font-bold mb-4">1. Dispositions préalables</div>
        <div class="mb-4">
            La société CENTRALE AUTOCAR est une Société par actions simplifiées à associé unique, au capital social de 2
            500 EUR, immatriculée au RCS de Paris sous le numéro 853867703, dont le siège social est situé 57, Rue de
            Clisson – 75013 Paris (France).
        </div>
        <div class="mb-4">
            Son numéro de TVA intracommunautaire est le FR58853867703
        </div>
        <div class="mb-4">
            La société CENTRALE AUTOCAR a pour activité le transport public collectif occasionnel de personnes.
        </div>
        <div class="mb-4">
            Plus précisément, elle propose un service de location d’autocars/minibus avec chauffeur pour des trajets
            sur-mesure, sur devis, à des particuliers et professionnels.
        </div>
        <div class="mb-4">
            La société CENTRALE AUTOCAR est propriétaire d’un site internet accessible à l’adresse
            http://www.centrale-autocar.com/, permettant de prendre connaissance dudit service.
        </div>
        <div class="font-bold mb-4">2. Mentions légales</div>
        <div class="mb-4">
            Le site CENTRALE AUTOCAR est édité par la société CENTRALE AUTOCAR, Société par actions simplifiées à
            associé unique, au capital social de 2 500 EUR, immatriculée au RCS de Paris sous le numéro 853867703, dont
            le siège social est situé 57, Rue de Clisson – 75013 Paris (France).
        </div>
        <div class="mb-4">
            Email : contact@centrale-autocar.com.
        </div>
        <div class="mb-4">
            Le directeur de la publication est Yoram Adjedj.
        </div>
        <div class="mb-4">
            Le site est hébergé par la société OVH
        </div>
        <div class="mb-4">
            Les Données Personnelles recueillies sont hébergées par OVH.
        </div>
        <div class="mb-4 font-bold">
            3. Politique de confidentialité
        </div>
        <div class="mb-4 font-bold">
            3.1 Définitions
        </div>
        <div class="mb-4">
            Dans la présente politique de confidentialité les mots ou expressions commençant avec une majuscule auront
            la signification suivante :
        </div>
        <div class="mb-4">
            <span class="font-bold">Client : </span>
            désigne toute personne physique ou morale, agissant en qualité de consommateur ou de professionnel,
            qui réserve sur devis, un trajet sur-mesure en autocar/minibus, dans les conditions ci-après définies, au
            profit d’un groupe de passagers.
        </div>
        <div class="mb-4">
            <span class="font-bold">Chauffeur : </span>
            désigne la personne qui conduit le Véhicule ou qui s’y trouve à bord, dans le cadre du Service,
            pour assurer la relève de son collègue.
        </div>
        <div class="mb-4">
            <span class="font-bold"> Conditions Générales de Location : </span>
            désigne les conditions générales de location de la Société.
        </div>
        <div class="mb-4">
            <span class="font-bold">  Confirmation : </span>
            désigne le document adressé par la Société au Client, afin de confirmer la location d’un
            autocar/minibus avec Chauffeur, pour un trajet sur-mesure, à la suite du paiement de ladite location, dans
            les conditions définies aux Conditions Générales de Location.
        </div>
        <div class="mb-4">
            <span class="font-bold"> Contrat : </span>
            ensemble composé du Devis et des Conditions Générales de Location de la Société acceptés par le
            Client, dans les conditions définies aux Conditions Générales de Location., et les éventuels avenants au
            Devis, signés par les deux Parties.
        </div>
        <div class="mb-4">
            <span class="font-bold">Données à Caractère Personnel / Données Personnelles : </span>
            désigne toute information susceptible de permettre
            l’identification d’une personne physique de manière directe ou indirecte (nom ; prénom ; adresse email ;
            adresse IP ; données de navigation ; etc.), conformément à la définition donnée par l’article 4 du Règlement
            Général de l’Union Européenne sur la protection des Données (RGPD 2016/679).
        </div>
        <div class="mb-4">
            <span class="font-bold">Membre d’équipage : </span>
            désigne la personne chargée de seconder le Chauffeur ou de remplir les fonctions
            d’hôtesse/steward.
        </div>
        <div class="mb-4">
            <span class="font-bold">  Partie(s) : </span>
            désigne individuellement la Société ou un Utilisateur et collectivement la Société et un
            Utilisateur.
        </div>
        <div class="mb-4">
            <span class="font-bold"> Passagers : </span>
            désigne les personnes qui prennent place à bord du Véhicule, à l’exception du Chauffeur.
        </div>
        <div class="mb-4">
            <span class="font-bold">Politique de Confidentialité : </span>
            désigne le présent document.
        </div>
        <div class="mb-4">
            <span class="font-bold"> Site : </span>
            désigne le site internet de la Société, accessible à l’adresse http://www.centrale-autocar.com/, au
            sein duquel est détaillé le Service.
        </div>
        <div class="mb-4">
            <span class="font-bold"> Service : </span>
            désigne le service de location d’autocars/minibus avec Chauffeur, pour des trajets sur-mesure,
            proposé par la Société, tel que plus amplement détaillé au Site, ainsi qu’aux présentes.
        </div>
        <div class="mb-4">
            <span class="font-bold"> Société : </span>
            désigne la société CENTRALE AUTOCAR.
        </div>
        <div class="mb-4">
            <span class="font-bold"> Véhicules : </span>
            désigne les autocars/minibus proposés à la location avec Chauffeur, par la Société.
        </div>
        <div class="mb-4">
            <span class="font-bold"> Utilisateur : </span>
            désigne toute personne physique qui utilise le Site, afin notamment de se renseigner sur le
            Service.
        </div>
        <div class="font-bold mb-4">3.2. Objet</div>
        <div class="mb-4"> La présente Politique de Confidentialité a pour objectif de définir les principes et lignes
            directrices mis en œuvre par la Société, en matière de traitement des Données à Caractère Personnel des
            Utilisateurs.
        </div>
        <div class="mb-4"> Plus précisément, la présente Politique de Confidentialité, détaille notamment l’ensemble des
            traitements desdites Données, des finalités poursuivies par ces derniers, ainsi que les moyens à la
            disposition de ses Utilisateurs pour exercer leurs droits.
        </div>
        <div class="mb-4 "> Pour toute information complémentaire sur la protection des Données Personnelles, la Société
            recommande aux Utilisateurs de se rendre sur le site de la CNIL (www.cnil.fr).
        </div>
        <div class="font-bold mb-4">3.3. Champ d’application</div>
        <div class="mb-4">La présente Politique de Confidentialité s’applique à l’ensemble des traitements de
            Données à Caractère Personnel des Utilisateurs, effectués par la Société.
        </div>
        <div class="font-bold mb-4">3.4. Données Personnelles</div>
        <div class="font-bold mb-4"> Collecte des Données Personnelles</div>
        <div class="mb-4"> Les Données Personnelles sont notamment collectées par la Société à partir du Site
            http://www.centrale-autocar.com/ (notamment par le biais de formulaires ou lors de l’inscription des
            Utilisateurs à la newsletter), de cookies, de scripts et du navigateur de l’Utilisateur.
        </div>
        <div class="mb-4"> Types, finalités et durée du traitement des Données Personnelles collectées
        </div>
        <div class="mb-4"> Conformément à la loi 78-17 du 6 janvier 1978, modifiée par les lois du 6 août 2004 et 20
            juin 2018, la Société s’engage à traiter les Données Personnelles de ses Utilisateurs, afin de :
        </div>
        <div class="mb-4 font-bold"> - gérer la « relation client »
        </div>
        <div class="mb-4"> La Société traite les Données Personnelles, afin de gérer la « relation client », par exemple
            en enregistrant des informations de base concernant les Utilsateurs ou encore en communiquant avec eux.
        </div>
        <div class="mb-4"> Dans ce cadre, la Société gère les informations d’identité de l’Utilisateur (prénom, nom,
            numéro de sécurité sociale) et ses coordonnées (numéro de téléphone et adresse email).
        </div>
        <div class="mb-4"> Le traitement est nécessaire pour que la Société puisse remplir ses obligations envers les
            Utilisateurs, conformément à ses conditions de vente.
        </div>
        <div class="mb-4"> Ces Données Personnelles sont conservées aux fins expliquées ci-dessus, pendant toute la
            durée de la « relation client. »
        </div>
        <div class="mb-4 font-bold"> - répondre aux demandes
        </div>
        <div class="mb-4"> La Société traite les Données Personnelles, afin de répondre aux demandes des Utilisateurs.
        </div>
        <div class="mb-4"> La Société traite les Données Personnelles suivantes pour répondre aux demandes des
            Utilisateurs : informations d’identité (prénom et nom de l’Utilisateur) et informations de contact (numéro
            de téléphone et adresse e-mail).
        </div>
        <div class="mb-4"> Le traitement est motivé par lintérêt légitime de la Société à répondre aux questions de ses
            Utilisateurs et à leur offrir un service client de qualité.
        </div>
        <div class="mb-4"> Si l’Utilisateur ne devient pas Client, les informations qu’il fournit à la Société
            volontairement, seront traitées en conséquence de son consentement explicite.
        </div>
        <div class="mb-4"> Ces Données Personnelles sont conservées à cet effet pendant six (6) mois si l’Utilisateur
            n’est pas Client, ou, si il est Client, pendant toute la durée de la « relation client. »
        </div>
        <div class="mb-4 font-bold"> - fourniture de newsletters
        </div>
        <div class="mb-4"> La Société traite les Données Personnelles des Utilisateurs, afin de leur fournir des
            newsletters.
        </div>
        <div class="mb-4"> La Société traite les Données Personnelles suivantes pour fournir des newsletters :
            informations d’identité (prénom et nom) et informations de contact (numéro de téléphone et adresse e-mail).
        </div>
        <div class="mb-4"> En s’inscrivant à la newsletter de la Société, l’Utilisateur donne son consentement au
            traitement de ses Données Personnelles à cette fin.
        </div>
        <div class="mb-4"> L’Utilisateur a le droit de se desincrire des listes de newsletters de la Société, à tout
            moment.
        </div>
        <div class="mb-4"> Ces Données Personnelles sont conservées à cet effet aussi longtemps que l’Utilisateur est
            inscrit à la newsletter de la Société.
        </div>
        <div class="mb-4 font-bold"> - obligations légales
        </div>
        <div class="mb-4"> La Société traite des Données Personnelles, afin de remplir ses obligations légales, par
            exemple en terme de comptabilité.
        </div>
        <div class="mb-4"> A cette fin, la Société traite les Données Personnelles suivantes : : informations d’identité
            (prénom et nom), informations de contact (numéro de téléphone et adresse e-mail) et informations de
            paiement.
        </div>
        <div class="mb-4"> Le traitement est nécessaire, afin que la Société puisse remplir les obligations légales qui
            sont les siennes, conformément aux lois et réglementations nationales et européennes.
        </div>
        <div class="mb-4"> Dans le cadre de l’exécution du Service, les destinataires des Données Personnellles
            collectées par la Société peuvent être les partenaires de la Société ou encore les organismes de paiement.
        </div>
        <div class="mb-4"> En outre, la Société est en droit de divulguer les Données Personnelles des Utilisateurs, en
            cas d’obligation par la loi ou en cas de violation des présentes par lesdits Utilisateurs.
        </div>
        <div class="mb-4"> Transfert des Données Personnelles vers des pays tiers
        </div>
        <div class="mb-4"> La Société s’efforce de traiter les Données Personnelles au sein de l’UE/EEE, afin que les
            Utilisateurs puissent être rassurés quant à la protection desdites Données Personnelles.
        </div>
        <div class="mb-4"> Dans certains cas, cependant, les Données Personnelles peuvent être transférées et traitées
            par des prestataires de services se trouvant dans des pays en dehors de l'UE/EEE.
        </div>
        <div class="mb-4"> Pour garantir que les Données Personnelles sont toujours protégées, la Société met en œuvre,
            en toutes circonstances, des mesures de sécurité adéquates, par exemple par des accors de protection des
            données qui obligent les sous-traitants à protéger les Données Personnelles de la même manière que la
            Société. Une liste à jour des pays vers lesquels la Société transfère, le cas échéant, les Données
            Personnelles peut être obtenue sur demande.
        </div>
        <div class="mb-4"> Les Utilisateurs ont également la possibilité de demander des informations sur les mesures de
            sécurité mises en place par la Société.
        </div>

        <div class="mb-4 font-bold">prévisionnelle</div>

        <div class="mb-4"> Le consentement des Utilisateurs est présumé aux fins d’utilisation desdites Données
            Personneles aux fins de souscription au Service proposé par la Société.
        </div>
        <div class="mb-4"> Lorsque les Données Personnelles des Utilisateurs sont utilisées à des fins marketing, le
            consentement préalable express des Utilisateurs est nécessaire. Les Utilisateurs ont toujours la possibilité
            de rétracter leur consentement en adressant un email à l’adresse : contact@centrale-autocar.com.
        </div>

        <div class="mb-4">3.6. Stockage</div>
        <div class="mb-4"> Le site est hébergé par la société OVH</div>
        <div class="mb-4"> Les Données Personnelles recueillies sont hébergées par la société OVH</div>

        <div class="mb-4 font-bold">3.7. Sécurité</div>

        <div class="mb-4"> La Société s’engage à mettre en œuvre tous les moyens nécessaires pour assurer la sécurité et
            la confidentialité des Données Personnelles.
        </div>
        <div class="mb-4"> Ainsi, afin de protéger les Données Personnelles des Utilisateurs de son Site, la Société
            prend un ensemble de précautions et suit les meilleurs pratiques en la matière, pour assurer que lesdites
            Données ne soient pas perdues, détournées, consultées, divulguées, modifiées ou détruites de manière
            inappropriée.
        </div>

        <div class="mb-4 font-bold">3.8. Cookies</div>

        <div class="mb-4 font-bold"> Qu’est qu’un cookie ?
        </div>
        <div class="mb-4"> Un cookie ou traceur est un fichier électronique déposé sur un terminal, tel qu’un
            ordinateur, une tablette ou un smartphone, et notamment lu lors de la connexion à un site internet, de la
            lecture d’un email, de l’installation ou de l’utilisation d’un logiciel ou d’une application mobile, quel
            que soit le type de terminal utilisé.
        </div>
        <div class="mb-4 font-bold"> Pourquoi la Société utilise-t-elle des cookies ?
        </div>
        <div class="mb-4"> Au cas particulier, le bon fonctionnement du Site implique la présence de cookies implantés
            dans l’ordinateur de l’Utilisateur, lors de sa connexion, afin d’enregistrer les informations relatives à la
            navigation (pages consultées, date et heure de la consultation, etc.) et l’identité de ses Utilisateurs.
        </div>
        <div class="mb-4"> Lors de la première connexion au Site, une bannière d’explication sur l’utilisation des
            cookies apparaîtra. Dès lors, en poursuivant la navigation, l’Utilisateur sera réputé avoir été informé et
            avoir accepté l’utilisation desdits cookies.
        </div>
        <div class="mb-4"> L’Utilisateur est en droit de s’opposer à l'utilisation des cookies en configurant lui-même
            son logiciel de navigation.
        </div>
        <div class="mb-4"> L’Utilisateur a également la possibilité de rétracter son consentement à l’utilisation de
            cookies, à tout moment.
        </div>
        <div class="mb-4 font-bold"> Type de cookies utilisés sur le Site
        </div>
        <div class="mb-4"> Cookies de session - ces cookies expirent lorsque l’Utilisateur ferme son navigateur web. La
            Société utilise ce type de cookie pour, entre autres, faciliter la navigation sur le Site. Certains de ces
            cookies sont essentiels au bon fonctionnement du Site. Cela signifie que si l’Utilisateur bloque
            complètement l'utilisation des cookies, il ne pourra pas utiliser toutes les fonctions du Site.
        </div>
        <div class="mb-4"> Cookies persistants - ces cookies restent sur l’appareil de l’Utilisateur pendant une période
            déterminée ou jusqu'à ce qu’il les supprime. Ce type de cookie est utilisé dans le but d'améliorer
            l'expérience de l’Utilisateur sur le Site, notamment en faisant en sorte qu’il n’ait pas à se connecter à
            chaque visite du Site. La Société utilise également les informations des cookies persistants pour conserver
            des statistiques sur le Site, afin qu’elle puisse améliorer son Service en fonction de ce que l’Utilisateur
            veut et apprécie.
        </div>
        <div class="mb-4 font-bold"> Plus d’information sur les cookies
        </div>
        <div class="mb-4"> https://www.cnil.fr/fr/cookies-les-outils-pour-les-maitriser
        </div>
        <div class="mb-4 font-bold"> Questions
        </div>
        <div class="mb-4"> Si vous avez des questions concernant cette politique de cookies, n'hésitez pas à contacter
            la Société par email à contact@centrale-autocar.com
        </div>

        <div class="mb-4 font-bold">4. Droits relatifs aux Données Personnelles</div>

        <div class="mb-4"> L’Utilisateur dispose, conformément aux réglementations nationales et européennes en vigueur
            d’un droit d’accès permanent, de modification, de rectification, de limitation, d’opposition et de
            portabilité s’agissant des informations le concernant.
        </div>
        <div class="mb-4"> Pour exercer ses droits, il suffit à l’Utilisateur d’écrire à l’adresse email suivante :
            contact@centrale-autocar.com
        </div>
        <div class="mb-4"> Par ailleurs, si un Utilisateur a des raisons de penser que la sécurité de ses Données
            Personnelles a été compromise ou que ces Données ont fait l’objet d’une utilisation abusive, il est en droit
            de contacter la Société à l’adresse email suivante : contact@centrale-autocar.com
        </div>
        <div class="mb-4"> La Société instruira les réclamations concernant l’utilisation et la divulgation de Données
            Personnelles et tentera de trouver une solution conformément à la réglementation en vigueur.
        </div>
        <div class="mb-4"> L’Utilisateur a également la possibilité de formuler une réclamation auprès de la CNIL, dont
            les coordonnées sont mentionnées sur son site www.cnil.fr.
        </div>

        <div class="mb-4 font-bold">5. Modification des présentes</div>
        <div class="mb-4"> La Société peut être amenée à modifier les présentes à tout moment, sans préavis, sous
            réserve d’en informer ses visiteurs dès l’entrée en vigueur de ces modifications par email et/ou par la
            publication desdites modifications sur son Site.
        </div>
        <div class="mb-4"> La Société actualisera les présentes en indiquant la date de dernière mise à jour en haut à
            droite des présentes.
        </div>

        <div class="mb-4 font-bold">6. Droits relatifs aux Données Personnelles</div>
        <div class="mb-4">Dans tous les cas, concernant l’utilisation de ses Données Personnelles, l’Utilisateur a la
            possibilité de contacter le délégué à la protection des données de la Société, à l’adresse
            contact@centrale-autocar.com
        </div>
        <div class="mb-4 font-bold">7. Loi applicable et juridiction compétente</div>
        <div class="mb-4">Les présentes sont soumises au droit français.</div>
        <div class="mb-4">Toute contestation relative aux présentes sera portée devant l’une des juridictions
            territorialement compétentes en vertu du Code de procédure civile.
        </div>
        <div class="mb-4 font-bold">8. Version française et étrangère</div>
        <div class="mb-4">Les présentes sont rédigées en français. En cas de contradiction ou de contresens, elles
            prévaudront sur toute autre version qui serait rédigée dans une autre langue à la demande de l’Utilisateur.
        </div>
        <div class="mb-4 font-bold">9. Election de domicile</div>
        <div class="mb-4">La Société élit domicile au 57, Rue de Clisson – 75013 Paris (France).</div>


    </div>
@endsection
