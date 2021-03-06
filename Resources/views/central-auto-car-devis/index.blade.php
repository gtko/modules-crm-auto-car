@extends('basecore::layout.main')

@section('content')

    <style>

        html, body{
            background:white;
        }

        @page {
            size: 1400px 1980px !important;
            /* this affects the margin in the printer settings */
            margin: 0px 0px 0px 0px;
        }

        @media print {
            .print-col-span-3 {
                grid-column: span 3 / span 3 !important;
            }

            .notcut {
                position: relative;
                break-inside: avoid;
                page-break-inside: avoid;
                -webkit-region-break-inside: avoid;
            }

            .newpage { page-break-before: always;}
            .margintopprint {margin-top:80px;}

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
        }
    </style>

    <div class="bg-white h-full w-full h-screen flex flex-col justify-between" style="font-family: 'Lato', sans-serif;">
        <div class="max-w-7xl w-full mx-auto pt-32 px-8 pb-16">
            <div class="grid grid-cols-3 gap-2">
                <div class="text-center mb-16 flex items-center w-full justify-center">
                    <img src="{{asset('/assets/logos/autocar-location.png')}}" alt="logo" class="h-24">
                </div>
                <div class="col-start-3 flex-col flex">
                    <span class="font-extrabold">{{ $devis->dossier->client->formatName }}</span>
                    <span class="uppercase">{{ $devis->dossier->client->address }}</span>
                    <span
                        class="uppercase">{{ $devis->dossier->client->codeZip }} {{ $devis->dossier->client->city }}</span>
                </div>
            </div>

            <div class="grid-cols-3 grid gap-2">
                <div class="flex flex-col">
                    <span class="mb-4">Devis n?? <span class="font-extrabold">{{ $devis->getNumStartRef() - 14194 }}</span></span>
                    <span>R??f??rent : Vanessa Lorant</span>
                    <span>Tel: +33 1 76 39 12 23 </span>
                    <span class="text-sm">Mail : infos@autocars-location.fr</span>
                </div>
                <div class="my-auto col-start-3">
                    <span>Paris, le {{ \Carbon\Carbon::createFromTimeString($devis->created_at ?? '')->translatedFormat('l d F Y') }}</span>
                </div>
            </div>

            <div class="flex flex-col mt-12">
                <span class="mb-4">Bonjour {{ $devis->dossier->client->formatName }}</span>
                <span>Nous avons le plaisir de vous communiquer nos conditions de prix pour votre projet de voyage <span
                        class="text-xs">(Aller et Retour)</span>:</span>

                @foreach(($devis->data['trajets'] ?? []) as $index => $trajet)
                    <div class="flex-col flex justify-center items-center font mx-auto my-6 font-black text-lg">
                        @if(($trajet['aller_distance']['origin_formatted'] ?? false) && ($trajet['aller_date_depart'] ?? false))
                            <span>Voyage n??{{$index + 1}}</span>
                            @if($trajet['aller_date_depart'] ?? '')
                                <span class="font-bold">le {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->translatedFormat('l d F Y') }}.</span>
                            @endif
                            <span> {{ $trajet['aller_point_depart'] }}</span>
                        @else
                            <span class="font-bold">Aucune date</span>
                        @endif
                    </div>
                @endforeach


                <span>Afin de vous r??server le v??hicule n??cessaire, nous vous remercions de nous faire conna??tre votre d??cision d??s que possible en nous retournant ce devis sign?? ?? l???adresse ci-dessus.</span>
                <span class="mt-4 mb-2">Descriptif du S??jour :</span>
            </div>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 text-left text-xs font-medium uppercase tracking-wider"></th>
                                    <th scope="col"
                                        class="px-6 text-left text-xs font-medium  uppercase tracking-wider  border-black border font-bold"
                                        style="background-color: gray">
                                        Horaire
                                    </th>
                                    <th scope="col"
                                        class="px-6 text-left text-xs font-medium  uppercase tracking-wider  border-black border font-bold"
                                        style="background-color: gray">
                                        Lieu
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach(($devis->data['trajets'] ?? []) as $index => $trajet)
                                    <tr class="bg-gray-200">
                                        <td class="px-6 py-2 whitespace-nowrap text-sm font-medium font-extrabold">
                                            Voyage n??{{$index + 1}}
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm  text-center">

                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm  font-bold text-center">

                                        </td>
                                    </tr>

                                    <tr class="bg-gray-200">
                                        <td class="px-6 whitespace-nowrap text-sm font-medium border-black border font-bold">
                                            D??part aller
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            @if(($trajet['aller_date_depart'] ?? ''))
                                                le {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->translatedFormat('d/m/Y') }}
                                                ?? {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->translatedFormat('H:i') }}
                                            @endif
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            {{ $trajet['aller_distance']['origin_formatted'] ?? '' }}
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-200">
                                        <td class="px-6 whitespace-nowrap text-sm font-medium border-black border font-bold">
                                            Arriv??e aller
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center"></td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            {{ $trajet['aller_distance']['destination_formatted'] ?? '' }}
                                        </td>
                                    </tr>

                                    @if(($trajet['retour_date_depart'] ?? ''))
                                    <tr class="bg-gray-200">
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold">
                                            D??part retour
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            @if(($trajet['retour_date_depart'] ?? ''))
                                                le {{ \Carbon\Carbon::createFromTimeString($trajet['retour_date_depart'] ?? '')->translatedFormat('d/m/Y') }}
                                                ?? {{ \Carbon\Carbon::createFromTimeString($trajet['retour_date_depart'] ?? '')->translatedFormat('H:i') }}                                        </td>
                                            @endif
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            {{ $trajet['retour_distance']['origin_formatted'] ?? '' }}
                                        </td>
                                    </tr>

                                    <tr class="bg-gray-200">
                                        <td class="px-6 whitespace-nowrap text-sm font-medium border-black border font-bold">
                                            Arriv??e retour
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center"></td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            {{ $trajet['retour_distance']['destination_formatted'] ?? '' }}
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach


                                </tbody>
                            </table>
                            @foreach(($devis->data['trajets'] ?? []) as $index => $trajet)
                                <livewire:crmautocar::central-auto-car-recap-devis :devis="$devis" :trajet-id="$index"
                                                                               :brand="$brand"/>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


            <div class="mt-4">
                <span>Restant ?? votre enti??re disposition, nous vous prions de croire, {{ $devis->dossier->client->formatName }}, ?? l???assurance de nos sentiments distingu??s.</span>
                <div class="mt-8 flex flex-col font-bold">
                    <span>Je reconnais avoir pris connaissance des conditions de vente.</span>
                    <span class="ml-24">Signature du client</span>
                </div>
            </div>

            <div class="newpage"></div>

            <div class="pt-5 w-full"></div>
            <div class="space-y-6 text-xs">
                <div class="w-full border border-black py-1 text-center font-extrabold mt-8">
                    CONDITIONS GENERALES DE VENTE
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">RESERVATION</div>
                    <div>
                        Le devis a ??t?? ??tabli sur des horaires approximatifs de voyage ainsi que le nombre de kilom??tres pr??visibles du circuit.
                        Tout changement dans le programme initial de la part du client est susceptible de modifier le prix initial.
                        Ainsi, la facturation est conforme au devis sauf si les conditions de transport sont modifi??es et peuvent entra??ner une surfacturation. Le kilom??trage suppl??mentaire est factur?? <span class="font-bold">1,60 EURO TTC</span>. L'heure compl??mentaire est factur??e <span class="font-bold">45 EURO TTC</span> avec 1 conducteur et <span class="font-bold">60 EURO TTC</span> avec 2 conducteurs. En aucun cas il ne sera accord?? de r??duction tarifaire si ces modifications entra??nent une r??duction des kilom??tres parcourus ou des heures de conduite.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">LEGISLATION DES TRANSPORTS</div>
                    <div>
                        L'organisation des voyages tient compte du respect de la r??glementation en vigueur ?? savoir :<br>
                        Dur??e de conduite journali??re d'un conducteur limit??e ?? 9 heures avec un maximum de 4 heures 30 de conduite continue avec obligatoirement pendant ou apr??s les 4 heures maximums de conduite continue avec une interruption de 45 minutes cons??cutives ou d???une interruption de 15 minutes puis 30 minutes.<br>
                        Pendant la p??riode de conduite de nuit c???est ?? dire de 21 heures ?? 6 heures du matin un conducteur ne peut pas conduire plus de 3 heures continues, avec obligatoirement pendant ou apr??s les 3 heures maximums de conduite continue avec une interruption de 45 minutes cons??cutives ou d???une interruption de 15 minutes puis 30 minutes.<br>
                        L'amplitude maximale est de 14 heures (l'amplitude est la dur??e s??parant la prise de service et la fin de service).<br>
                        Avec 2 conducteurs la dur??e d???amplitude est de 18 heures maximum.<br>
                        La conduite journali??re doit ??tre au maximum de 9 heures par jour et 10 heures deux fois par semaine.<br>
                        Repos journalier du conducteur : 11 heures cons??cutives, pouvant ??tre r??duites ?? : 9 heures cons??cutives trois fois par semaine.<br>
                        Repos hebdomadaire 45 heures cons??cutives, pouvant ??tre r??duites ?? 24 heures.<br>
                        Double ??quipage : 8 heures cons??cutives au cours de chaque p??riode de 30 heures.<br>
                        Nombre maximum de jours de conduite continu en France et ?? l?????tranger : 12 jours.<br><br>

                        <span class="font-extrabold text-md">Toute r??servation ne sera prise en consid??ration qu'?? r??ception du devis adress?? par le client et rev??tu de sa signature et de la mention "Bon pour accord".</span><br><br>

                        Un acompte de 30 % sur le prix du voyage devra accompagner cette confirmation. Le solde intervenant au plus tard 45 jours avant votre voyage.<br><br>

                        Dans le cas d'une r??servation tardive, le r??glement est exig?? en totalit?? d??s l'inscription.<br>
                        Le client n'ayant pas vers?? le solde ?? la date convenue pourra ??tre consid??r?? comme ayant annul?? son voyage.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 1 ??? Objet et champ d???application</div>
                    <div>
                        Le pr??sent contrat est applicable au transport public routier non urbain de personnes, en transport int??rieur, pour tout service occasionnel collectif, effectu?? par un transporteur au moyen d???un ou plusieurs autocars. Les conditions dans lesquelles sont ex??cut??s ces services, notamment les prix applicables, doivent assurer une juste r??mun??ration du transporteur permettant la couverture des co??ts r??els du service r??alis?? dans des conditions normales d???organisation, de s??curit??, de qualit??, de respect des r??glementations et conform??ment aux dispositions de la loi n?? 82-1153 du 30 d??cembre 1982, notamment de ses articles 6 ?? 9, ainsi que des textes pris pour son application. Ainsi, les op??rations de transport ne doivent en aucun cas ??tre conduites dans des conditions incompatibles avec la r??glementation des conditions de travail et de s??curit??. Ce contrat r??gle les relations du donneur d???ordre et du transporteur. Il s???applique de plein droit, en totalit?? ou en partie, ?? d??faut de stipulations ??crites contraires ou diff??rentes convenues entre les parties.
                        <br><br>
                        Conform??ment aux articles L211-7 et L211-17 du Code du tourisme, les dispositions des articles R211-3 ?? R211-11 du Code du tourisme, dont le texte est ci-dessous reproduit, ne sont pas applicables pour les op??rations de r??servation ou de vente des titres de transport n???entrant pas dans le cadre d???un forfait touristique.

                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 2 ??? D??finitions</div>
                    <div>
                        Aux fins du pr??sent contrat, on entend par : donneur d???ordre ?? la partie qui conclut le contrat de transport avec le transporteur. Le donneur d???ordre peut ??tre le b??n??ficiaire du transport ou l???interm??diaire charg?? d???organiser le transport pour le b??n??ficiaire ; ?? transporteur ?? la Soci??t?? retenue lors de l???appel d???offres et aupr??s de laquelle vous serez engag??s, , qui s???engage, en vertu du contrat, ?? faire acheminer directement ou en sous-traitance, dans les conditions vis??es ?? l???article 1, ?? titre on??reux, un groupe de personnes et leurs bagages, d???un lieu d??fini ?? destination d???un autre lieu d??fini ; ?? conducteur ?? la personne qui conduit l???autocar ou qui se trouve ?? bord de l???autocar dans le cadre du service pour assurer la rel??ve de son coll??gue ; ?? membre d?????quipage ?? la personne charg??e de seconder le conducteur ou de remplir les fonctions d???h??tesse, de steward ou de guide ; ?? passagers ?? les personnes qui prennent place ?? bord de l???autocar ?? l???exception du conducteur ; ?? service ?? le service occasionnel collectif, qui comporte la mise d???un autocar ?? la disposition exclusive d???un groupe ou de plusieurs groupes d???au moins dix personnes.
                        Ces groupes sont constitu??s pr??alablement ?? leur prise en charge ; ?? transport en commun d???enfants ?? le transport organis?? ?? titre principal pour des personnes de moins de dix-huit ans ; ?? prise en charge initiale ?? le moment o?? le premier passager commence ?? monter dans l???autocar ; ?? d??pose finale ?? le moment o?? le dernier passager ach??ve de descendre de l???autocar ; ?? dur??e de mise ?? disposition ?? le temps qui s?????coule entre le moment o?? l???autocar est mis ?? disposition du donneur d???ordre et celui o?? le transporteur retrouve la libert?? d???usage de celui-ci. La dur??e de mise ?? disposition inclut le temps de prise en charge et de d??pose des passagers et de leurs bagages, variable selon la nature du service ; ?? points d???arr??t interm??diaires ?? les lieux autres que le point de prise en charge initiale et le point de d??pose finale, o?? l???autocar doit s???arr??ter
                        ?? la demande exprim??e par le donneur d???ordre lors de la conclusion du contrat ; ?? horaires ?? les horaires d??finis en fonction de conditions normales de circulation et de d??roulement de transport, garantissant le respect des obligations de s??curit?? et de la r??glementation sociale relative aux temps de conduite et de repos des conducteurs ; ?? itin??raire ?? l???itin??raire laiss?? ?? l???initiative du transporteur, sauf exigence particuli??re du donneur d???ordre explicitement indiqu??e, ?? charge pour lui d???en informer le transporteur avant le d??but du service ; ?? bagages ?? les biens identifi??s transport??s ?? bord de l???autocar ou de sa remorque et appartenant aux passagers ; ?? bagages plac??s en soute ?? les bagages achemin??s dans la soute ou la remorque de l???autocar ; ?? bagages ?? main ?? les bagages que le passager conserve avec lui.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 3 ??? Informations et documents ?? fournir au transporteur</div>
                    <div>
                        Pr??alablement ?? la mise du ou des autocars ?? la disposition du groupe constitu??, le donneur d???ordre fournit au transporteur par ??crit, ou par tout autre proc??d?? en permettant la m??morisation, les indications d??finies ci-apr??s. Dates, horaires et itin??raires : la date, l???heure et le lieu de d??but et de fin de mise ?? disposition de l???autocar ; la date, l???heure et le lieu de prise en charge initiale des passagers ainsi que la date, l???heure et le lieu de leur d??pose finale ; la date, l???heure et le lieu des points d???arr??t interm??diaires ; le cas ??ch??ant, l???itin??raire impos??. Composition du groupe ?? transporter : le nombre maximum de personnes qui compose le groupe ; le nombre maximum de personnes ?? mobilit?? r??duite, dont le nombre de personnes en fauteuil roulant ; le nombre maximum de personnes de moins de dix-huit ans dans le cadre d???un transport en commun d???enfants et le nombre d???accompagnateurs. Liste nominative des passagers : Par arr??t?? minist??riel, une liste nominative (nom, pr??nom) des passagers pr??sents dans le v??hicule de transport en commun est obligatoire depuis le 3 Juillet 2009 pour les transports r??alis??s hors du p??rim??tre constitu?? par le d??partement de prise en charge du groupe et les d??partements limitrophes. Dans le cadre des transports d???enfants, la liste doit en outre comporter les coordonn??es t??l??phoniques d???une personne ?? contacter pour chaque enfant transport??. L?????tablissement de cette liste est de la responsabilit?? du client qui devra la remettre au conducteur au moment du d??part. Nature des bagages : le poids et le volume global approximatifs ; la pr??ciosit?? et la fragilit?? ??ventuelles ; les autres sp??cificit??s ??ventuelles. Moyen de communication : les coordonn??es t??l??phoniques permettant au transporteur de joindre le donneur d???ordre ?? tout moment (vingt-quatre heures sur vingt- quatre et sept jours sur sept).
                        <br><br>
                        En cas de modifications d???une ou plusieurs de ces donn??es apr??s la r??servation, le transporteur se r??serve le droit de refuser la prestation sans pour autant ne devoir aucune compensation au donneur d???ordres.
                        <br><br>
                        Pr??alablement ?? la conclusion du contrat, le vendeur doit communiquer au consommateur les informations sur les prix, les dates et les autres ??l??ments constitutifs des prestations fournies ?? l'occasion du voyage ou du s??jour tels que :
                        <br><br>
                        1?? La destination, les moyens, les caract??ristiques et les cat??gories de transports utilis??s ;
                        <br><br>
                        2?? Le mode d'h??bergement, sa situation, son niveau de confort et ses principales caract??ristiques, son homologation et son classement touristique correspondant ?? la r??glementation ou aux usages du pays d'accueil ;
                        <br><br>
                        3?? Les prestations de restauration propos??es ;
                        <br><br>
                        4?? La description de l'itin??raire lorsqu'il s'agit d'un circuit
                        <br><br>
                        5?? Les formalit??s administratives et sanitaires ?? accomplir par les nationaux ou par les ressortissants d'un autre Etat membre de l'Union europ??enne ou d'un Etat partie ?? l'accord sur l'Espace ??conomique europ??en en cas, notamment, de franchissement des fronti??res ainsi que leurs d??lais d'accomplissement ;
                        <br><br>
                        6?? Les visites, excursions et les autres services inclus dans le forfait ou ??ventuellement disponibles moyennant un suppl??ment de prix ;
                        <br><br>
                        7?? La taille minimale ou maximale du groupe permettant la r??alisation du voyage ou du s??jour ainsi que, si la r??alisation du voyage ou du s??jour est subordonn??e ?? un nombre minimal de participants, la date limite d'information du consommateur en cas d'annulation du voyage ou du s??jour ; cette date ne peut ??tre fix??e ?? moins de vingt et un jours avant le d??part ;
                        <br><br>
                        8?? Le montant ou le pourcentage du prix ?? verser ?? titre d'acompte ?? la conclusion du contrat ainsi que le calendrier de paiement du solde
                        <br><br>
                        9?? Les modalit??s de r??vision des prix telles que pr??vues par le contrat en application de l'article R. 211-8 ;
                        <br><br>
                        10?? Les conditions d'annulation de nature contractuelle ;
                        <br><br>
                        11?? Les conditions d'annulation d??finies aux articles R. 211-9, R. 211-10 et R. 211-11
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 4 ??? Caract??ristiques de l???autocar</div>
                    <div>
                        Chaque autocar mis ?? disposition du donneur d???ordre par le transporteur doit ??tre : en bon ??tat de marche et r??pondre en tous points aux obligations techniques r??glementaires ; adapt?? ?? la distance ?? parcourir, aux caract??ristiques du groupe et aux exigences ??ventuelles du donneur d???ordre ; compatible avec le poids et le volume des bagages pr??vus. Les passagers sont responsables des d??gradations occasionn??es par leur fait ?? l???autocar. Toute d??gradation relev??e ?? l???int??rieur de l???autocar et caus??e par les passagers sera factur??e au client. Le client
                        est tenu de constater et informer le conducteur de l???autocar si des d??gradations ??taient constat??es avant le d??part du voyage. La soci??t?? se r??serve le droit de constater des d??gradations ??galement une fois le v??hicule rentr?? ?? notre garage jusqu????? la location suivante.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 5 ??? S??curit?? ?? bord de l???autocar</div>
                    <div>
                        Le nombre maximal de personnes pouvant ??tre transport??es ne peut exc??der celui inscrit sur l???attestation d???am??nagement ou la carte violette. Le transporteur est responsable de la s??curit?? du transport, y compris lors de chaque mont??e et de chaque descente des passagers de l???autocar. Le conducteur prend les mesures n??cessaires ?? la s??curit?? et donne en cas de besoin des instructions aux passagers, qui sont tenus de les respecter. Des arr??ts sont laiss??s ?? l???initiative du transporteur ou du conducteur pour r??pondre aux obligations de s??curit?? et de respect de la r??glementation sociale relative aux temps de conduite et de repos des conducteurs, ou ?? d???autres n??cessit??s. Pour les autocars dont les si??ges sont ??quip??s de ceinture de s??curit??, le transporteur informe les passagers de l???obligation du port de cet ??quipement. Sauf exceptions pr??vues au code de la route, le port de la ceinture s???applique ?? chaque passager, adulte et enfant. S???il s???agit d???un groupe accompagn??, le transporteur comme le conducteur doivent conna??tre le nom des personnes ayant une responsabilit?? d???organisation ou de surveillance, dont la nature doit ??tre pr??cis??e. Ces personnes d??sign??es comme responsables doivent conna??tre les conditions d???organisation du transport convenues avec le transporteur et d??tenir la liste des personnes composant le groupe. Le donneur d???ordre doit prendre les dispositions pour que ces informations leur soient communiqu??es avant le d??but du transport. A la demande du donneur d???ordre, le conducteur donne avant le d??part une information sur les mesures et les dispositifs de s??curit??, adapt??e ?? la nature du service et aux passagers. Si l???autocar en est ??quip??, le si??ge basculant, dit si??ge de convoyeur, est uniquement r??serv?? ?? un conducteur ou ?? un membre d?????quipage. Sauf d??rogations l??gales, le transport de marchandises dangereuses est interdit dans les autocars. Si une d??rogation s???applique, le donneur d???ordre informe le transporteur. Concernant plus sp??cifiquement les transports en commun d???enfants : Le conducteur doit : s???assurer de la pr??sence des pictogrammes r??glementaires du signal de transport d???enfants ; utiliser imp??rativement le signal de d??tresse ?? l???arr??t de l???autocar lors de la mont??e ou de la descente des enfants ; employer les mesures de protection de fa??on adapt??e en cas d???arr??t prolong?? de l???autocar. Le donneur d???ordre doit : veiller ?? ce que les personnes d??sign??es comme responsables aient les connaissances n??cessaires en mati??re de s??curit?? pour les transports en commun d???enfants ; demander aux personnes d??sign??es comme responsables de dispenser les consignes de s??curit?? ?? appliquer (danger autour de l???autocar, obligation de rester assis...), notamment celle concernant le port obligatoire de la ceinture de s??curit??, et de veiller ?? leur respect ; donner consigne aux personnes d??sign??es comme responsables de compter les enfants un ?? un lors de chaque mont??e et descente de l???autocar ; veiller ?? r??partir dans l???autocar les accompagnateurs en liaison avec le conducteur, notamment en fonction des exigences de s??curit??.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 6 ??? Bagages</div>
                    <div>
                        Le transporteur n???est pas responsable des bagages plac??s en soute. Ces bagages doivent faire l???objet d???un ??tiquetage par leur propri??taire. En cas de perte ou d???avarie de bagages plac??s en soute, aucune indemnit?? ne pourra ??tre r??clam??e par le donneur d???ordre ou autres passagers du groupe transport??. Le transporteur, ou son pr??pos??-conducteur, se r??serve le droit de refuser les bagages dont le poids, les dimensions ou la nature ne correspondent pas ?? ce qui avait ??t?? convenu avec le donneur d???ordre, ainsi que ceux qu???il estime pr??judiciable ?? la
                        s??curit?? du transport. Les bagages ?? main, dont le passager conserve la garde, demeurent sous son enti??re responsabilit??. Avant l???ex??cution du service, le donneur d???ordre informe chaque passager des dispositions ci-dessus, notamment en ce qui concerne la garde des bagages ?? main et l???absence d???indemnisation des bagages plac??s en soute. A la fin du transport, le donneur d???ordre, son repr??sentant et les passagers sont tenus de s???assurer qu???aucun objet n???a ??t?? oubli?? dans l???autocar. Le transporteur d??cline toute responsabilit?? en cas de d??t??rioration ou de vol de tout ce qui pourrait y avoir ??t?? laiss??.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 7 ??? Diffusion publique de musique ou projection d???une oeuvre audiovisuelle</div>
                    <div>
                        La diffusion publique dans un autocar d?????uvres musicales, cin??matographiques, t??l??visuelles ou d???enregistrements personnels doit faire l???objet d???une d??claration pr??alable et ??tre autoris??e par les titulaires de droits d???auteur.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 8 ??? R??mun??ration du transport et des prestations annexes et compl??mentaires</div>
                    <div>
                        La r??mun??ration du transporteur comprend le prix du transport stricto sensu, qui inclut notamment la r??mun??ration du ou des conducteurs, celui des prestations annexes et compl??mentaires, auxquelles s???ajoutent les frais li??s ?? l?????tablissement et ?? la gestion administrative et informatique du contrat de transport, ainsi que toute taxe li??e au transport et, ou, tout droit dont la perception est mise ?? la charge du transporteur. Le prix du transport est ??galement ??tabli en fonction du type d???autocar utilis??, de ses ??quipements propres, d?????ventuels ??quipements compl??mentaires, du nombre de places offertes, du volume souhait?? des soutes, de la distance du transport, des caract??ristiques et suj??tions particuli??res de circulation. Toute prestation annexe ou compl??mentaire est r??mun??r??e au prix convenu.
                        <br><br>
                        Tel est le cas notamment : du stationnement de longue dur??e sur un site ; des transferts a??riens, ferroviaires, maritimes du ou des conducteur(s) en cas de longue p??riode d???inactivit?? ; des transports compl??mentaires maritimes (ferries) ou ferroviaires (tunnels) ; Toute modification du contrat de transport initial imputable au donneur d???ordre, telle que pr??vue ?? l???article 12, entra??ne un r??ajustement des conditions de r??mun??ration du transporteur. Cette r??mun??ration peut ??galement ??tre modifi??e s???il survient un ??v??nement impr??vu. Le prix de transport initialement convenu est r??vis?? en cas de variations significatives des charges de l???entreprise de transport, qui tiennent ?? des conditions ext??rieures ?? cette derni??re, tel notamment le prix des carburants, et dont la partie demanderesse justifie par tous moyens.

                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 9 ??? Modalit??s de conclusion et de paiement du contrat</div>
                    <div>
                        Le contrat n???est r??put?? conclu qu???apr??s r??ception du devis/contrat signe et/ou de la validation ??lectronique sur le devis aussi appel?? ?? Confirmation en ligne de votre r??servation ?? ET apr??s acceptation par le transporteur qui doit s???assurer de la disponibilit?? d???un ou de plusieurs v??hicules ainsi que de chauffeurs disponible pour la prestation. Apres r??ception d???une validation par le donneur d???ordres (client) le transporteur b??n??ficiera une p??riode de 10 jours ouvr??s pour pr??venir le donneur d???ordres qu???il ne pourra pas effectuer cette prestation, le donneur d???ordres ne pourra en aucun cas r??clamer de compensation financi??re si le transporteur d??cide de ne pas effectuer cette prestation. Le solde du prix du transport, des prestations annexes et compl??mentaires, est exigible avant le d??but du service. Lorsque le transporteur consent au donneur d???ordre des d??lais de paiement, le bon de commande, le contrat ou la facture font mention de la date ?? laquelle le paiement doit intervenir. Toute commande implique de plein droit l???acceptation des pr??sentes conditions g??n??rales de ventes.
                        <br><br>
                        Toute conditions contraires qui pourraient ??tre stipul??es par l???acheteur dans ses propres
                        <br><br>
                        conditions g??n??rales d???achat, dans ses bons de commande, dans sa correspondances, nous sont inopposables et r??put??es non ??crites ?? notre ??gard. Les seules informations valables quant ?? l???application de votre commande sont celles qui sont stipul??es sur le bon de commande sign??. Toutes autres informations, orales ou ??crites, ne sont donn??es qu????? titre indicatif et ne peuvent nous engager. Toute modification de la commande initiale devra ??tre formul??e par ??crit pr??alablement ?? l???ex??cution de la prestation et fera donc l???objet d???un nouveau bon de commande. Les seules informations valables quant ?? l???application de votre commande sont celles qui sont stipul??es dans le bon de commande sign??. Toutes autres informations, orales ou ??crites, ne sont donn??es qu????? titre indicatif et ne peuvent nous engager. Tout retard dans le paiement, apr??s mise en demeure rest??e sans effet, entra??ne de plein droit le versement de p??nalit??s d???un montant au moins ??quivalent ?? une fois et demie le taux l??gal, telles que d??finies ?? l???article L. 441-6 du code de commerce, sans pr??judice de la r??paration, dans les conditions du droit commun, de tout autre dommage r??sultant de ce retard. Le non-paiement total ou partiel d???une facture ?? une seule ??ch??ance emporte, sans formalit??, la d??ch??ance du terme entra??nant l???exigibilit?? imm??diate du r??glement, sans mise en demeure, de toutes sommes dues, m??me ?? terme, ?? la date de ce manquement et autorise le transporteur ?? exiger le paiement comptant avant l???ex??cution de toute nouvelle op??ration. En cas de non-paiement d???une ??ch??ance au terme convenu, ainsi qu???en cas de non-respect de l???une quelconque des obligations pr??vues dans les pr??sentes conditions g??n??rales de vente la prestation ne sera pas r??alis??e, ce plein droit et sans aucune formalit??, les acomptes vers??s nous demeurent acquis ?? titre de premiers dommages et int??r??ts

                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 10 ??? R??siliation du contrat de transport</div>
                    <div>
                        Lorsque, avant le d??part, le donneur d???ordre r??silie le contrat, il doit en informer le transporteur par lettre recommand??e avec accus?? de r??ception. Le cas ??ch??ant, une indemnit?? forfaitaire sera due au transporteur ??gale ?? - 30 % du prix du service si l???annulation intervient ?? plus de 30 jours avant le d??part
                        <br><br>
                        - 50 % du prix du service si l???annulation intervient entre 30 et 14 jours avant le d??part
                        <br><br>
                        -  70 % du prix du service si l???annulation intervient entre 13 et 7 jours avant le d??part
                        <br><br>
                        - 100 % du prix du service si l???annulation intervient moins de 7 jours avant le d??part.
                        <br><br>
                        En cas de r??siliation par le transporteur, le donneur d???ordre a droit au remboursement imm??diat des sommes vers??es.
                        <br><br>
                        Le client accepte que la validation du contrat d??mat??rialis??, par l???utilisation du ?? clic de validation ?? sur le site de Louerunbus.fr, des pr??sentes conditions g??n??rales de vente, constitue la manifestation irr??vocable d???acceptation des termes du contrat. Cette acceptation est faite au nom de tous les participants aux voyages.
                        <br><br>
                        L???acceptation d??mat??rialis??e des termes du contrat et de l???acceptation des Conditions G??n??rales de Vente vaut commande d??finitive et ne pourra ??tre r??tract??e.
                        <br><br>
                        Si le client ne se pr??sente pas aux heures et lieux mentionn??s sur le carnet de voyage qui lui aura ??t?? remis, aucun remboursement ne peut intervenir. De la m??me fa??on, aucun remboursement ne peut intervenir s'il ne peut pr??senter les documents de police ou de sant?? exig??s pour son voyage tels que passeport, visa, carte d'identit??, certificat de vaccination.
                        <br><br>
                        Tout s??jour interrompu ou abr??g?? ou toute prestation non consomm??e de votre fait pour quelque cause que ce soit ne donne lieu ?? aucun remboursement.
                        <br><br>
                        Si le client a souscrit une assurance optionnelle annulation ou protection compl??te (couvrant notamment l'interruption de s??jour), il devra appeler le plateau d???assistance de l???assureur.
                        <br><br>
                        Toute demande d'annulation doit ??tre faite par lettre recommand??e avec accus?? de r??ception ou par mail  avec signature. Sera consid??r??e comme effective la date de r??c??ption ?? laquelle le courrier/mail  de l'acheteur

                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 11 ??? Ex??cution du contrat de transport</div>
                    <div>
                        Le donneur d???ordre accepte que le transporteur sous-traite le service ?? un autre transporteur public routier de personnes. Le transporteur ainsi missionn?? sera responsable de toutes les obligations d??coulant du contrat.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 12 ??? Modification du contrat de transport en cours de r??alisation</div>
                    <div>
                        Toute nouvelle instruction du donneur d???ordre ayant pour objet la modification des conditions initiales d???ex??cution du transport en cours de r??alisation doit ??tre confirm??e imm??diatement au transporteur par ??crit ou par tout autre proc??d?? en permettant la m??morisation. Le transporteur n???est pas tenu d???accepter ces nouvelles instructions, notamment si elles sont de nature ?? l???emp??cher d???honorer les engagements de transport pris initialement. Il doit en aviser imm??diatement le donneur d???ordre par ??crit ou par tout autre proc??d?? en permettant la m??morisation. Toute modification au contrat peut entra??ner un r??ajustement du prix convenu.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 13 ??? Ev??nements fortuits</div>
                    <div>
                        Les horaires de d??part et d???arriv??e ainsi que les itin??raires sont mentionn??s ?? titre indicatif et sont susceptibles de modifications par le transporteur si les circonstances l???imposent notamment pour des raisons de l??gislation, de s??curit??, de cas fortuit ou de force majeure. Aucun d??dommagement ni remboursement ne seront accord??s au client dans ces circonstances. Le client ne pourra pr??tendre ?? aucune indemnit?? si l???annulation du contrat, du fait du transporteur, est impos??e par des circonstances de force majeure, des raisons tenant ?? la s??curit?? des voyageurs ou toute raison ind??pendante de la volont?? du transporteur. Si le voyage devait ??tre modifi?? en cas d?????v??nement fortuit ou de force majeure aucun remboursement ou d??dommagement ne sera accord?? au client. Pour les bons de commandes sign??s ?? un prix convenu entre le transporteur et le donneur d???ordre plus d???un mois avant le d??part, le transporteur peut de fa??on tout ?? fait exceptionnelle ??tre amen?? ?? modifier son prix jusqu????? 1 mois avant le d??but de la prestation, en fonction d?????v??nements ??conomiques modifiant le co??t de revient de la prestation (augmentation du prix des carburants...). Dans ce cas le transporteur fera une autre offre au donneur d???ordre, qui sera libre de l???accepter ou de la refuser. En cas de refus, le bon de commande sera alors annul?? et le transporteur remboursera sans d??lai le donneur d???ordre des sommes d??j?? vers??es. Le donneur d???ordre ne pourra pr??tendre ?? aucune autre indemnisation du fait de cette annulation.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 14 ??? Retards</div>
                    <div>
                        Le transporteur ne pourra ??tre tenu pour responsable des retards dus ?? des ??v??nements ind??pendants de sa volont?? (par exemple : les pannes m??caniques, les embouteillages, les accidents, les gr??ves, les conditions climatiques, les d??viations, le fait d???un ou de plusieurs passagers, le fait d???un tiers, tout cas fortuit ou de force majeure) ou encore dict??s par la n??cessit?? d???assurer la s??curit?? des personnes transport??es. Aucune indemnit?? ni remboursement ne seront accord??s au client dans ces circonstances. En cas de retard ?? un a??roport, ?? une gare ou tout autre lieu de rendez-vous les ??ventuels frais d???h??tellerie, de restauration, de train, de taxi ou de tout autre frais cons??cutifs ?? ce retard, ne seront pas pris en charge par notre soci??t??. Si le client d??cide de son propre chef d???utiliser d???autres moyens de transport que ceux propos??s sur son devis, pour quelque raison que ce soit, il ne pourra pr??tendre ?? aucune indemnisation.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 15 ??? Formalit??s</div>
                    <div>
                        Pour les d??placements ?? l?????tranger, chaque participant est invit?? ?? se renseigner sur les l??gislations de police et douani??re en vigueur et ?? s???y conformer. Le transporteur ne saurait ??tre tenu pour responsable de toute infraction ?? ces r??gles.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 16 ??? R??clamations </div>
                    <div>
                        Toute r??clamation devra nous parvenir par lettre recommand??e avec accus?? de r??ception, dans les huit jours qui suivent l???ex??cution de la commande. Au-del??, aucune r??clamation ou contestation ne pourra plus ??tre formul??e, rembours??e ou indemnis??e.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 17 ??? Diff??rents et attribution de juridiction</div>
                    <div>
                        Tous diff??rents pouvant r??sulter de l???application de nos contrats sont de la comp??tence exclusive du tribunal de commerce.
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
