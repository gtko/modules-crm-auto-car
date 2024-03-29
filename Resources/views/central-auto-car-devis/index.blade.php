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
                    <span class="mb-4">Devis n° <span class="font-extrabold">{{ $devis->getNumStartRef() - 14194 }}</span></span>
                    <span>Réfèrent : Vanessa Lorant</span>
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
                            <span>Voyage n°{{$index + 1}}</span>
                            @if($trajet['aller_date_depart'] ?? '')
                                <span class="font-bold">le {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->translatedFormat('l d F Y') }}.</span>
                            @endif
                            <span> {{ $trajet['aller_point_depart'] }}</span>
                        @else
                            <span class="font-bold">Aucune date</span>
                        @endif
                    </div>
                @endforeach


                <span>Afin de vous réserver le véhicule nécessaire, nous vous remercions de nous faire connaître votre décision dès que possible en nous retournant ce devis signé à l’adresse ci-dessus.</span>
                <span class="mt-4 mb-2">Descriptif du Séjour :</span>
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
                                            Voyage n°{{$index + 1}}
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm  text-center">

                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm  font-bold text-center">

                                        </td>
                                    </tr>

                                    <tr class="bg-gray-200">
                                        <td class="px-6 whitespace-nowrap text-sm font-medium border-black border font-bold">
                                            Départ aller
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            @if(($trajet['aller_date_depart'] ?? ''))
                                                le {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->translatedFormat('d/m/Y') }}
                                                à {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->translatedFormat('H:i') }}
                                            @endif
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            {{ $trajet['aller_distance']['origin_formatted'] ?? '' }}
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-200">
                                        <td class="px-6 whitespace-nowrap text-sm font-medium border-black border font-bold">
                                            Arrivée aller
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center"></td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            {{ $trajet['aller_distance']['destination_formatted'] ?? '' }}
                                        </td>
                                    </tr>

                                    @if(($trajet['retour_date_depart'] ?? ''))
                                    <tr class="bg-gray-200">
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold">
                                            Départ retour
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            @if(($trajet['retour_date_depart'] ?? ''))
                                                le {{ \Carbon\Carbon::createFromTimeString($trajet['retour_date_depart'] ?? '')->translatedFormat('d/m/Y') }}
                                                à {{ \Carbon\Carbon::createFromTimeString($trajet['retour_date_depart'] ?? '')->translatedFormat('H:i') }}                                        </td>
                                            @endif
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            {{ $trajet['retour_distance']['origin_formatted'] ?? '' }}
                                        </td>
                                    </tr>

                                    <tr class="bg-gray-200">
                                        <td class="px-6 whitespace-nowrap text-sm font-medium border-black border font-bold">
                                            Arrivée retour
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
                <span>Restant à votre entière disposition, nous vous prions de croire, {{ $devis->dossier->client->formatName }}, à l’assurance de nos sentiments distingués.</span>
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
                        Le devis a été établi sur des horaires approximatifs de voyage ainsi que le nombre de kilomètres prévisibles du circuit.
                        Tout changement dans le programme initial de la part du client est susceptible de modifier le prix initial.
                        Ainsi, la facturation est conforme au devis sauf si les conditions de transport sont modifiées et peuvent entraîner une surfacturation. Le kilométrage supplémentaire est facturé <span class="font-bold">1,60 EURO TTC</span>. L'heure complémentaire est facturée <span class="font-bold">45 EURO TTC</span> avec 1 conducteur et <span class="font-bold">60 EURO TTC</span> avec 2 conducteurs. En aucun cas il ne sera accordé de réduction tarifaire si ces modifications entraînent une réduction des kilomètres parcourus ou des heures de conduite.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">LEGISLATION DES TRANSPORTS</div>
                    <div>
                        L'organisation des voyages tient compte du respect de la réglementation en vigueur à savoir :<br>
                        Durée de conduite journalière d'un conducteur limitée à 9 heures avec un maximum de 4 heures 30 de conduite continue avec obligatoirement pendant ou après les 4 heures maximums de conduite continue avec une interruption de 45 minutes consécutives ou d’une interruption de 15 minutes puis 30 minutes.<br>
                        Pendant la période de conduite de nuit c’est à dire de 21 heures à 6 heures du matin un conducteur ne peut pas conduire plus de 3 heures continues, avec obligatoirement pendant ou après les 3 heures maximums de conduite continue avec une interruption de 45 minutes consécutives ou d’une interruption de 15 minutes puis 30 minutes.<br>
                        L'amplitude maximale est de 14 heures (l'amplitude est la durée séparant la prise de service et la fin de service).<br>
                        Avec 2 conducteurs la durée d’amplitude est de 18 heures maximum.<br>
                        La conduite journalière doit être au maximum de 9 heures par jour et 10 heures deux fois par semaine.<br>
                        Repos journalier du conducteur : 11 heures consécutives, pouvant être réduites à : 9 heures consécutives trois fois par semaine.<br>
                        Repos hebdomadaire 45 heures consécutives, pouvant être réduites à 24 heures.<br>
                        Double équipage : 8 heures consécutives au cours de chaque période de 30 heures.<br>
                        Nombre maximum de jours de conduite continu en France et à l’étranger : 12 jours.<br><br>

                        <span class="font-extrabold text-md">Toute réservation ne sera prise en considération qu'à réception du devis adressé par le client et revêtu de sa signature et de la mention "Bon pour accord".</span><br><br>

                        Un acompte de 30 % sur le prix du voyage devra accompagner cette confirmation. Le solde intervenant au plus tard 45 jours avant votre voyage.<br><br>

                        Dans le cas d'une réservation tardive, le règlement est exigé en totalité dès l'inscription.<br>
                        Le client n'ayant pas versé le solde à la date convenue pourra être considéré comme ayant annulé son voyage.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 1 – Objet et champ d’application</div>
                    <div>
                        Le présent contrat est applicable au transport public routier non urbain de personnes, en transport intérieur, pour tout service occasionnel collectif, effectué par un transporteur au moyen d’un ou plusieurs autocars. Les conditions dans lesquelles sont exécutés ces services, notamment les prix applicables, doivent assurer une juste rémunération du transporteur permettant la couverture des coûts réels du service réalisé dans des conditions normales d’organisation, de sécurité, de qualité, de respect des règlementations et conformément aux dispositions de la loi n° 82-1153 du 30 décembre 1982, notamment de ses articles 6 à 9, ainsi que des textes pris pour son application. Ainsi, les opérations de transport ne doivent en aucun cas être conduites dans des conditions incompatibles avec la règlementation des conditions de travail et de sécurité. Ce contrat règle les relations du donneur d’ordre et du transporteur. Il s’applique de plein droit, en totalité ou en partie, à défaut de stipulations écrites contraires ou différentes convenues entre les parties.
                        <br><br>
                        Conformément aux articles L211-7 et L211-17 du Code du tourisme, les dispositions des articles R211-3 à R211-11 du Code du tourisme, dont le texte est ci-dessous reproduit, ne sont pas applicables pour les opérations de réservation ou de vente des titres de transport n’entrant pas dans le cadre d’un forfait touristique.

                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 2 – Définitions</div>
                    <div>
                        Aux fins du présent contrat, on entend par : donneur d’ordre » la partie qui conclut le contrat de transport avec le transporteur. Le donneur d’ordre peut être le bénéficiaire du transport ou l’intermédiaire chargé d’organiser le transport pour le bénéficiaire ; « transporteur » la Société retenue lors de l’appel d’offres et auprès de laquelle vous serez engagés, , qui s’engage, en vertu du contrat, à faire acheminer directement ou en sous-traitance, dans les conditions visées à l’article 1, à titre onéreux, un groupe de personnes et leurs bagages, d’un lieu défini à destination d’un autre lieu défini ; « conducteur » la personne qui conduit l’autocar ou qui se trouve à bord de l’autocar dans le cadre du service pour assurer la relève de son collègue ; « membre d’équipage » la personne chargée de seconder le conducteur ou de remplir les fonctions d’hôtesse, de steward ou de guide ; « passagers » les personnes qui prennent place à bord de l’autocar à l’exception du conducteur ; « service » le service occasionnel collectif, qui comporte la mise d’un autocar à la disposition exclusive d’un groupe ou de plusieurs groupes d’au moins dix personnes.
                        Ces groupes sont constitués préalablement à leur prise en charge ; « transport en commun d’enfants » le transport organisé à titre principal pour des personnes de moins de dix-huit ans ; « prise en charge initiale » le moment où le premier passager commence à monter dans l’autocar ; « dépose finale » le moment où le dernier passager achève de descendre de l’autocar ; « durée de mise à disposition » le temps qui s’écoule entre le moment où l’autocar est mis à disposition du donneur d’ordre et celui où le transporteur retrouve la liberté d’usage de celui-ci. La durée de mise à disposition inclut le temps de prise en charge et de dépose des passagers et de leurs bagages, variable selon la nature du service ; « points d’arrêt intermédiaires » les lieux autres que le point de prise en charge initiale et le point de dépose finale, où l’autocar doit s’arrêter
                        à la demande exprimée par le donneur d’ordre lors de la conclusion du contrat ; « horaires » les horaires définis en fonction de conditions normales de circulation et de déroulement de transport, garantissant le respect des obligations de sécurité et de la réglementation sociale relative aux temps de conduite et de repos des conducteurs ; « itinéraire » l’itinéraire laissé à l’initiative du transporteur, sauf exigence particulière du donneur d’ordre explicitement indiquée, à charge pour lui d’en informer le transporteur avant le début du service ; « bagages » les biens identifiés transportés à bord de l’autocar ou de sa remorque et appartenant aux passagers ; « bagages placés en soute » les bagages acheminés dans la soute ou la remorque de l’autocar ; « bagages à main » les bagages que le passager conserve avec lui.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 3 – Informations et documents à fournir au transporteur</div>
                    <div>
                        Préalablement à la mise du ou des autocars à la disposition du groupe constitué, le donneur d’ordre fournit au transporteur par écrit, ou par tout autre procédé en permettant la mémorisation, les indications définies ci-après. Dates, horaires et itinéraires : la date, l’heure et le lieu de début et de fin de mise à disposition de l’autocar ; la date, l’heure et le lieu de prise en charge initiale des passagers ainsi que la date, l’heure et le lieu de leur dépose finale ; la date, l’heure et le lieu des points d’arrêt intermédiaires ; le cas échéant, l’itinéraire imposé. Composition du groupe à transporter : le nombre maximum de personnes qui compose le groupe ; le nombre maximum de personnes à mobilité réduite, dont le nombre de personnes en fauteuil roulant ; le nombre maximum de personnes de moins de dix-huit ans dans le cadre d’un transport en commun d’enfants et le nombre d’accompagnateurs. Liste nominative des passagers : Par arrêté ministériel, une liste nominative (nom, prénom) des passagers présents dans le véhicule de transport en commun est obligatoire depuis le 3 Juillet 2009 pour les transports réalisés hors du périmètre constitué par le département de prise en charge du groupe et les départements limitrophes. Dans le cadre des transports d’enfants, la liste doit en outre comporter les coordonnées téléphoniques d’une personne à contacter pour chaque enfant transporté. L’établissement de cette liste est de la responsabilité du client qui devra la remettre au conducteur au moment du départ. Nature des bagages : le poids et le volume global approximatifs ; la préciosité et la fragilité éventuelles ; les autres spécificités éventuelles. Moyen de communication : les coordonnées téléphoniques permettant au transporteur de joindre le donneur d’ordre à tout moment (vingt-quatre heures sur vingt- quatre et sept jours sur sept).
                        <br><br>
                        En cas de modifications d’une ou plusieurs de ces données après la réservation, le transporteur se réserve le droit de refuser la prestation sans pour autant ne devoir aucune compensation au donneur d’ordres.
                        <br><br>
                        Préalablement à la conclusion du contrat, le vendeur doit communiquer au consommateur les informations sur les prix, les dates et les autres éléments constitutifs des prestations fournies à l'occasion du voyage ou du séjour tels que :
                        <br><br>
                        1° La destination, les moyens, les caractéristiques et les catégories de transports utilisés ;
                        <br><br>
                        2° Le mode d'hébergement, sa situation, son niveau de confort et ses principales caractéristiques, son homologation et son classement touristique correspondant à la réglementation ou aux usages du pays d'accueil ;
                        <br><br>
                        3° Les prestations de restauration proposées ;
                        <br><br>
                        4° La description de l'itinéraire lorsqu'il s'agit d'un circuit
                        <br><br>
                        5° Les formalités administratives et sanitaires à accomplir par les nationaux ou par les ressortissants d'un autre Etat membre de l'Union européenne ou d'un Etat partie à l'accord sur l'Espace économique européen en cas, notamment, de franchissement des frontières ainsi que leurs délais d'accomplissement ;
                        <br><br>
                        6° Les visites, excursions et les autres services inclus dans le forfait ou éventuellement disponibles moyennant un supplément de prix ;
                        <br><br>
                        7° La taille minimale ou maximale du groupe permettant la réalisation du voyage ou du séjour ainsi que, si la réalisation du voyage ou du séjour est subordonnée à un nombre minimal de participants, la date limite d'information du consommateur en cas d'annulation du voyage ou du séjour ; cette date ne peut être fixée à moins de vingt et un jours avant le départ ;
                        <br><br>
                        8° Le montant ou le pourcentage du prix à verser à titre d'acompte à la conclusion du contrat ainsi que le calendrier de paiement du solde
                        <br><br>
                        9° Les modalités de révision des prix telles que prévues par le contrat en application de l'article R. 211-8 ;
                        <br><br>
                        10° Les conditions d'annulation de nature contractuelle ;
                        <br><br>
                        11° Les conditions d'annulation définies aux articles R. 211-9, R. 211-10 et R. 211-11
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 4 – Caractéristiques de l’autocar</div>
                    <div>
                        Chaque autocar mis à disposition du donneur d’ordre par le transporteur doit être : en bon état de marche et répondre en tous points aux obligations techniques réglementaires ; adapté à la distance à parcourir, aux caractéristiques du groupe et aux exigences éventuelles du donneur d’ordre ; compatible avec le poids et le volume des bagages prévus. Les passagers sont responsables des dégradations occasionnées par leur fait à l’autocar. Toute dégradation relevée à l’intérieur de l’autocar et causée par les passagers sera facturée au client. Le client
                        est tenu de constater et informer le conducteur de l’autocar si des dégradations étaient constatées avant le départ du voyage. La société se réserve le droit de constater des dégradations également une fois le véhicule rentré à notre garage jusqu’à la location suivante.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 5 – Sécurité à bord de l’autocar</div>
                    <div>
                        Le nombre maximal de personnes pouvant être transportées ne peut excéder celui inscrit sur l’attestation d’aménagement ou la carte violette. Le transporteur est responsable de la sécurité du transport, y compris lors de chaque montée et de chaque descente des passagers de l’autocar. Le conducteur prend les mesures nécessaires à la sécurité et donne en cas de besoin des instructions aux passagers, qui sont tenus de les respecter. Des arrêts sont laissés à l’initiative du transporteur ou du conducteur pour répondre aux obligations de sécurité et de respect de la réglementation sociale relative aux temps de conduite et de repos des conducteurs, ou à d’autres nécessités. Pour les autocars dont les sièges sont équipés de ceinture de sécurité, le transporteur informe les passagers de l’obligation du port de cet équipement. Sauf exceptions prévues au code de la route, le port de la ceinture s’applique à chaque passager, adulte et enfant. S’il s’agit d’un groupe accompagné, le transporteur comme le conducteur doivent connaître le nom des personnes ayant une responsabilité d’organisation ou de surveillance, dont la nature doit être précisée. Ces personnes désignées comme responsables doivent connaître les conditions d’organisation du transport convenues avec le transporteur et détenir la liste des personnes composant le groupe. Le donneur d’ordre doit prendre les dispositions pour que ces informations leur soient communiquées avant le début du transport. A la demande du donneur d’ordre, le conducteur donne avant le départ une information sur les mesures et les dispositifs de sécurité, adaptée à la nature du service et aux passagers. Si l’autocar en est équipé, le siège basculant, dit siège de convoyeur, est uniquement réservé à un conducteur ou à un membre d’équipage. Sauf dérogations légales, le transport de marchandises dangereuses est interdit dans les autocars. Si une dérogation s’applique, le donneur d’ordre informe le transporteur. Concernant plus spécifiquement les transports en commun d’enfants : Le conducteur doit : s’assurer de la présence des pictogrammes réglementaires du signal de transport d’enfants ; utiliser impérativement le signal de détresse à l’arrêt de l’autocar lors de la montée ou de la descente des enfants ; employer les mesures de protection de façon adaptée en cas d’arrêt prolongé de l’autocar. Le donneur d’ordre doit : veiller à ce que les personnes désignées comme responsables aient les connaissances nécessaires en matière de sécurité pour les transports en commun d’enfants ; demander aux personnes désignées comme responsables de dispenser les consignes de sécurité à appliquer (danger autour de l’autocar, obligation de rester assis...), notamment celle concernant le port obligatoire de la ceinture de sécurité, et de veiller à leur respect ; donner consigne aux personnes désignées comme responsables de compter les enfants un à un lors de chaque montée et descente de l’autocar ; veiller à répartir dans l’autocar les accompagnateurs en liaison avec le conducteur, notamment en fonction des exigences de sécurité.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 6 – Bagages</div>
                    <div>
                        Le transporteur n’est pas responsable des bagages placés en soute. Ces bagages doivent faire l’objet d’un étiquetage par leur propriétaire. En cas de perte ou d’avarie de bagages placés en soute, aucune indemnité ne pourra être réclamée par le donneur d’ordre ou autres passagers du groupe transporté. Le transporteur, ou son préposé-conducteur, se réserve le droit de refuser les bagages dont le poids, les dimensions ou la nature ne correspondent pas à ce qui avait été convenu avec le donneur d’ordre, ainsi que ceux qu’il estime préjudiciable à la
                        sécurité du transport. Les bagages à main, dont le passager conserve la garde, demeurent sous son entière responsabilité. Avant l’exécution du service, le donneur d’ordre informe chaque passager des dispositions ci-dessus, notamment en ce qui concerne la garde des bagages à main et l’absence d’indemnisation des bagages placés en soute. A la fin du transport, le donneur d’ordre, son représentant et les passagers sont tenus de s’assurer qu’aucun objet n’a été oublié dans l’autocar. Le transporteur décline toute responsabilité en cas de détérioration ou de vol de tout ce qui pourrait y avoir été laissé.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 7 – Diffusion publique de musique ou projection d’une oeuvre audiovisuelle</div>
                    <div>
                        La diffusion publique dans un autocar d’œuvres musicales, cinématographiques, télévisuelles ou d’enregistrements personnels doit faire l’objet d’une déclaration préalable et être autorisée par les titulaires de droits d’auteur.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 8 – Rémunération du transport et des prestations annexes et complémentaires</div>
                    <div>
                        La rémunération du transporteur comprend le prix du transport stricto sensu, qui inclut notamment la rémunération du ou des conducteurs, celui des prestations annexes et complémentaires, auxquelles s’ajoutent les frais liés à l’établissement et à la gestion administrative et informatique du contrat de transport, ainsi que toute taxe liée au transport et, ou, tout droit dont la perception est mise à la charge du transporteur. Le prix du transport est également établi en fonction du type d’autocar utilisé, de ses équipements propres, d’éventuels équipements complémentaires, du nombre de places offertes, du volume souhaité des soutes, de la distance du transport, des caractéristiques et sujétions particulières de circulation. Toute prestation annexe ou complémentaire est rémunérée au prix convenu.
                        <br><br>
                        Tel est le cas notamment : du stationnement de longue durée sur un site ; des transferts aériens, ferroviaires, maritimes du ou des conducteur(s) en cas de longue période d’inactivité ; des transports complémentaires maritimes (ferries) ou ferroviaires (tunnels) ; Toute modification du contrat de transport initial imputable au donneur d’ordre, telle que prévue à l’article 12, entraîne un réajustement des conditions de rémunération du transporteur. Cette rémunération peut également être modifiée s’il survient un événement imprévu. Le prix de transport initialement convenu est révisé en cas de variations significatives des charges de l’entreprise de transport, qui tiennent à des conditions extérieures à cette dernière, tel notamment le prix des carburants, et dont la partie demanderesse justifie par tous moyens.

                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 9 – Modalités de conclusion et de paiement du contrat</div>
                    <div>
                        Le contrat n’est réputé conclu qu’après réception du devis/contrat signe et/ou de la validation électronique sur le devis aussi appelé « Confirmation en ligne de votre réservation » ET après acceptation par le transporteur qui doit s’assurer de la disponibilité d’un ou de plusieurs véhicules ainsi que de chauffeurs disponible pour la prestation. Apres réception d’une validation par le donneur d’ordres (client) le transporteur bénéficiera une période de 10 jours ouvrés pour prévenir le donneur d’ordres qu’il ne pourra pas effectuer cette prestation, le donneur d’ordres ne pourra en aucun cas réclamer de compensation financière si le transporteur décide de ne pas effectuer cette prestation. Le solde du prix du transport, des prestations annexes et complémentaires, est exigible avant le début du service. Lorsque le transporteur consent au donneur d’ordre des délais de paiement, le bon de commande, le contrat ou la facture font mention de la date à laquelle le paiement doit intervenir. Toute commande implique de plein droit l’acceptation des présentes conditions générales de ventes.
                        <br><br>
                        Toute conditions contraires qui pourraient être stipulées par l’acheteur dans ses propres
                        <br><br>
                        conditions générales d’achat, dans ses bons de commande, dans sa correspondances, nous sont inopposables et réputées non écrites à notre égard. Les seules informations valables quant à l’application de votre commande sont celles qui sont stipulées sur le bon de commande signé. Toutes autres informations, orales ou écrites, ne sont données qu’à titre indicatif et ne peuvent nous engager. Toute modification de la commande initiale devra être formulée par écrit préalablement à l’exécution de la prestation et fera donc l’objet d’un nouveau bon de commande. Les seules informations valables quant à l’application de votre commande sont celles qui sont stipulées dans le bon de commande signé. Toutes autres informations, orales ou écrites, ne sont données qu’à titre indicatif et ne peuvent nous engager. Tout retard dans le paiement, après mise en demeure restée sans effet, entraîne de plein droit le versement de pénalités d’un montant au moins équivalent à une fois et demie le taux légal, telles que définies à l’article L. 441-6 du code de commerce, sans préjudice de la réparation, dans les conditions du droit commun, de tout autre dommage résultant de ce retard. Le non-paiement total ou partiel d’une facture à une seule échéance emporte, sans formalité, la déchéance du terme entraînant l’exigibilité immédiate du règlement, sans mise en demeure, de toutes sommes dues, même à terme, à la date de ce manquement et autorise le transporteur à exiger le paiement comptant avant l’exécution de toute nouvelle opération. En cas de non-paiement d’une échéance au terme convenu, ainsi qu’en cas de non-respect de l’une quelconque des obligations prévues dans les présentes conditions générales de vente la prestation ne sera pas réalisée, ce plein droit et sans aucune formalité, les acomptes versés nous demeurent acquis à titre de premiers dommages et intérêts

                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 10 – Résiliation du contrat de transport</div>
                    <div>
                        Lorsque, avant le départ, le donneur d’ordre résilie le contrat, il doit en informer le transporteur par lettre recommandée avec accusé de réception. Le cas échéant, une indemnité forfaitaire sera due au transporteur égale à - 30 % du prix du service si l’annulation intervient à plus de 30 jours avant le départ
                        <br><br>
                        - 50 % du prix du service si l’annulation intervient entre 30 et 14 jours avant le départ
                        <br><br>
                        -  70 % du prix du service si l’annulation intervient entre 13 et 7 jours avant le départ
                        <br><br>
                        - 100 % du prix du service si l’annulation intervient moins de 7 jours avant le départ.
                        <br><br>
                        En cas de résiliation par le transporteur, le donneur d’ordre a droit au remboursement immédiat des sommes versées.
                        <br><br>
                        Le client accepte que la validation du contrat dématérialisé, par l’utilisation du « clic de validation » sur le site de Louerunbus.fr, des présentes conditions générales de vente, constitue la manifestation irrévocable d’acceptation des termes du contrat. Cette acceptation est faite au nom de tous les participants aux voyages.
                        <br><br>
                        L’acceptation dématérialisée des termes du contrat et de l’acceptation des Conditions Générales de Vente vaut commande définitive et ne pourra être rétractée.
                        <br><br>
                        Si le client ne se présente pas aux heures et lieux mentionnés sur le carnet de voyage qui lui aura été remis, aucun remboursement ne peut intervenir. De la même façon, aucun remboursement ne peut intervenir s'il ne peut présenter les documents de police ou de santé exigés pour son voyage tels que passeport, visa, carte d'identité, certificat de vaccination.
                        <br><br>
                        Tout séjour interrompu ou abrégé ou toute prestation non consommée de votre fait pour quelque cause que ce soit ne donne lieu à aucun remboursement.
                        <br><br>
                        Si le client a souscrit une assurance optionnelle annulation ou protection complète (couvrant notamment l'interruption de séjour), il devra appeler le plateau d’assistance de l’assureur.
                        <br><br>
                        Toute demande d'annulation doit être faite par lettre recommandée avec accusé de réception ou par mail  avec signature. Sera considérée comme effective la date de récéption à laquelle le courrier/mail  de l'acheteur

                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 11 – Exécution du contrat de transport</div>
                    <div>
                        Le donneur d’ordre accepte que le transporteur sous-traite le service à un autre transporteur public routier de personnes. Le transporteur ainsi missionné sera responsable de toutes les obligations découlant du contrat.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 12 – Modification du contrat de transport en cours de réalisation</div>
                    <div>
                        Toute nouvelle instruction du donneur d’ordre ayant pour objet la modification des conditions initiales d’exécution du transport en cours de réalisation doit être confirmée immédiatement au transporteur par écrit ou par tout autre procédé en permettant la mémorisation. Le transporteur n’est pas tenu d’accepter ces nouvelles instructions, notamment si elles sont de nature à l’empêcher d’honorer les engagements de transport pris initialement. Il doit en aviser immédiatement le donneur d’ordre par écrit ou par tout autre procédé en permettant la mémorisation. Toute modification au contrat peut entraîner un réajustement du prix convenu.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 13 – Evénements fortuits</div>
                    <div>
                        Les horaires de départ et d’arrivée ainsi que les itinéraires sont mentionnés à titre indicatif et sont susceptibles de modifications par le transporteur si les circonstances l’imposent notamment pour des raisons de législation, de sécurité, de cas fortuit ou de force majeure. Aucun dédommagement ni remboursement ne seront accordés au client dans ces circonstances. Le client ne pourra prétendre à aucune indemnité si l’annulation du contrat, du fait du transporteur, est imposée par des circonstances de force majeure, des raisons tenant à la sécurité des voyageurs ou toute raison indépendante de la volonté du transporteur. Si le voyage devait être modifié en cas d’événement fortuit ou de force majeure aucun remboursement ou dédommagement ne sera accordé au client. Pour les bons de commandes signés à un prix convenu entre le transporteur et le donneur d’ordre plus d’un mois avant le départ, le transporteur peut de façon tout à fait exceptionnelle être amené à modifier son prix jusqu’à 1 mois avant le début de la prestation, en fonction d’évènements économiques modifiant le coût de revient de la prestation (augmentation du prix des carburants...). Dans ce cas le transporteur fera une autre offre au donneur d’ordre, qui sera libre de l’accepter ou de la refuser. En cas de refus, le bon de commande sera alors annulé et le transporteur remboursera sans délai le donneur d’ordre des sommes déjà versées. Le donneur d’ordre ne pourra prétendre à aucune autre indemnisation du fait de cette annulation.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 14 – Retards</div>
                    <div>
                        Le transporteur ne pourra être tenu pour responsable des retards dus à des événements indépendants de sa volonté (par exemple : les pannes mécaniques, les embouteillages, les accidents, les grèves, les conditions climatiques, les déviations, le fait d’un ou de plusieurs passagers, le fait d’un tiers, tout cas fortuit ou de force majeure) ou encore dictés par la nécessité d’assurer la sécurité des personnes transportées. Aucune indemnité ni remboursement ne seront accordés au client dans ces circonstances. En cas de retard à un aéroport, à une gare ou tout autre lieu de rendez-vous les éventuels frais d’hôtellerie, de restauration, de train, de taxi ou de tout autre frais consécutifs à ce retard, ne seront pas pris en charge par notre société. Si le client décide de son propre chef d’utiliser d’autres moyens de transport que ceux proposés sur son devis, pour quelque raison que ce soit, il ne pourra prétendre à aucune indemnisation.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 15 – Formalités</div>
                    <div>
                        Pour les déplacements à l’étranger, chaque participant est invité à se renseigner sur les législations de police et douanière en vigueur et à s’y conformer. Le transporteur ne saurait être tenu pour responsable de toute infraction à ces règles.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 16 – Réclamations </div>
                    <div>
                        Toute réclamation devra nous parvenir par lettre recommandée avec accusé de réception, dans les huit jours qui suivent l’exécution de la commande. Au-delà, aucune réclamation ou contestation ne pourra plus être formulée, remboursée ou indemnisée.
                    </div>
                </div>
                <div class="notcut">
                    <div class="font-extrabold text-md">Article 17 – Différents et attribution de juridiction</div>
                    <div>
                        Tous différents pouvant résulter de l’application de nos contrats sont de la compétence exclusive du tribunal de commerce.
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
