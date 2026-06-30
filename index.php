<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Geral Do Huambol</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>

<body>

    <!-- ══════════════════════════════════════════
     HEADER / NAVBAR segunda
    ══════════════════════════════════════════ -->
    <nav class="navbar" id="navbar">
        <a href="#" class="nav-logo" id="logo-inicio">
            <div class="nav-logo-texto">Hospital Geral Do Huambo</div>
        </a>

        <ul class="nav-links">
            <li><a href="#home" class="ativo">Home</a></li>
            <li><a href="#especialidades">Especialidades</a></li>
            <li><a href="#metodologia">Como Funciona</a></li>
            <li><a href="#sobre">Sobre Nós</a></li>
        </ul>

        <div class="nav-acoes">
            <a href="paciente/login.php" class="btn-marcar">Login</a>
        </div>
    </nav>
    <!-- ══════════════════════════════════════════
     HEADER / Fim
    ══════════════════════════════════════════ -->


    <!-- ══════════════════════════════════════════
     HERO SECTION
    ══════════════════════════════════════════ -->
    <section class="hero" id="home">
        <div class="hero-conteudo">

            <!-- Texto e Informações à esquerda -->
            <div class="hero-texto">
                <div class="hero-badge">
                    CERTIFICADO PELO MINISTÉRIO DA SAÚDE
                </div>

                <h1 class="hero-titulo">
                    Sua saúde, com atendimento
                    prioritário e digital.
                </h1>

                <p class="hero-desc">
                    Marque consultas, acompanhe seu histórico médico e aceda aos
                    resultados tudo de forma rápida, segura, sem filas e sem sair do conforto de sua casa.
                </p>

                <div class="hero-botoes">
                    <a href="paciente/registo.php" class="btn-hero-primario">
                        Criar Conta Grátis
                    </a>
                    <a href="#sobre" class="btn-hero-sec">
                        Saber Mais
                    </a>
                </div>

                <!-- Micro Stats integrados ao Hero -->
                <div class="hero-stats-row">
                    <div class="hero-stat-item">
                        <span class="hero-stat-number" data-alvo="1200">0</span>
                        <span class="hero-stat-label">Consultas Realizadas</span>
                    </div>
                    <div class="hero-stat-item">
                        <span class="hero-stat-number" data-alvo="35">0</span>
                        <span class="hero-stat-label">Médicos Especialistas</span>
                    </div>
                </div>
            </div>

            <!-- Imagem e Visual à direita para pub ao hospital -->
            <div class="hero-visual">
                <div class="hero-imagem-wrapper">
                    <img src="assets/img/hj.jpg" alt="Médico auxiliando paciente com tablet digital">
                </div>
            </div>

        </div>
    </section>

    <!-- ══════════════════════════════════════════
     RECURSOS "Eficiência em cada etapa"
    ══════════════════════════════════════════ -->
    <section class="secao-recursos" id="especialidades">
        <div class="recursos-header">
            <h2>Eficiência em cada etapa</h2>
            <p>Desenvolvemos uma infraestrutura digital robusta para garantir que seu atendimento seja o mais fluido possível.</p>
        </div>

        <div class="recursos-grid">

            <!-- primeira etapa: Consulta Marcada -->
            <div class="recurso-card">
                <div>
                    <div class="recurso-icone-box">📅</div>
                    <h3>Consulta Marcada</h3>
                    <p>Agende seus horários em menos de 1 minuto. Escolha o especialista, a modalidade (presencial ou vídeo) e receba confirmação instantânea.</p>
                </div>
                <div>

                </div>
            </div>

            <!-- Segunda etapa: Resultado Disponível (Destacado Azul Escuro) -->
            <div class="recurso-card destacado">
                <div>
                    <div class="recurso-icone-box">📄</div>
                    <h3>Resultado Disponível</h3>
                    <p>Acesse exames, receitas e laudos diretamente no seu portal. Notificações automáticas assim que o laboratório liberar seu arquivo.</p>
                </div>
                <div class="medicos-avatares-box">
                    <div class="avatar-grupo">
                        <img src="assets/img/doctor1.png" alt="Avatar Médico 1">
                        <img src="assets/img/doctor2.png" alt="Avatar Médico 2">
                    </div>
                    <span class="avatar-mais">+10</span>
                </div>
            </div>

            <!--  Terceira etapa: Dados Protegidos -->
            <div class="recurso-card">
                <div>
                    <div class="recurso-icone-box">🔒</div>
                    <h3>Dados Protegidos</h3>
                    <p>Segurança de nível bancário com criptografia de ponta a ponta. Sua privacidade é nossa prioridade absoluta e em conformidade com a LGPD.</p>
                </div>
                <div>

                </div>
            </div>

        </div>
    </section>

    <!-- ══════════════════════════════════════════
     Estatistica de satisfação dos nossos serviços
    ══════════════════════════════════════════ -->
    <section class="secao-stats" id="sobre">
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-grande-numero" data-alvo="06">0</span>
                <span class="stat-desc-label">Especialidades</span>
            </div>
            <div class="stat-item">
                <span class="stat-grande-numero" data-alvo="98">0</span>
                <span class="stat-desc-label">Satisfação</span>
            </div>
            <div class="stat-item">
                <span class="stat-grande-numero" data-alvo="24">0</span>
                <span class="stat-desc-label">Suporte Ativo</span>
            </div>
            <div class="stat-item">
                <span class="stat-grande-numero" data-alvo="500">0</span>
                <span class="stat-desc-label">Pacientes Atendidos</span>
            </div>
        </div>
    </section>

    <!-- ══════════════════════════════════════════
     CALL TO ACTION SECTION
    ══════════════════════════════════════════ -->
    <section class="secao-cta" id="metodologia">
        <div class="cta-container">
            <h2>Pronto para transformar sua experiência com saúde?</h2>
            <p>Junte-se a milhares de pacientes que já estão usando a plataforma digital mais avançada do país.</p>
            <div class="cta-botoes-row">
                <a href="#" class="btn-cta-branco">Falar com um Consultor</a>

            </div>
        </div>
    </section>

    <!-- ══════════════════════════════════════════
     FOOTER
    ══════════════════════════════════════════ -->
    <footer class="footer-principal">
        <div class="footer-grid">

            <!-- Coluna 1: Info e Social -->
            <div class="footer-col-info">
                <h3>Hospital Geral Do Huambo</h3>
                <p>A mais moderna plataforma de telemedicina e gestão de saúde do Brasil. Atendimento humano, tecnologia digital.</p>
                <div class="footer-sociais">
                    <a href="#" class="social-icone">🔗</a>
                    <a href="#" class="social-icone">🌐</a>
                </div>
            </div>

            <!-- Coluna 2: Links Úteis -->
            <div class="footer-col-links">
                <h4>Links Úteis</h4>
                <ul>
                    <li><a href="#">Termos de Uso</a></li>
                    <li><a href="#">Política de Privacidade</a></li>
                    <li><a href="#">Direitos do Paciente</a></li>
                    <li><a href="medicos/login.php">Portal do Médico (Área Clínica)</a></li>
                </ul>
            </div>

            <!-- Coluna 3: Contato -->
            <div class="footer-col-contato">
                <h4>Contato</h4>
                <p><strong>Telefone:</strong> (+244) 921410303</p>
                <p><strong>E-mail:</strong> hospitalgeralldohuambo.com</p>
            </div>

        </div>

        <div class="footer-divisor"></div>
        <p class="footer-copyright">&copy; <?php echo date('Y'); ?> Hospital Geraal Do Huambo.</p>
    </footer>

    <!-- ══════════════════════════════════════════
     JAVASCRIPT PARA MICRO-INTERAÇÕES
    ══════════════════════════════════════════ -->
    <script>
        // ── Navbar: adiciona classe ao fazer scroll ──
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 40);
        });

        // ── Links activos conforme scroll ──
        const secoes = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-links a');

        const observador = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navLinks.forEach(link => {
                        link.classList.remove('ativo');
                        if (link.getAttribute('href') === '#' + entry.target.id) {
                            link.classList.add('ativo');
                        }
                    });
                }
            });
        }, {
            threshold: 0.4
        });

        secoes.forEach(s => observador.observe(s));

        // ── Contador animado nos stats ──
        const contadores = document.querySelectorAll('[data-alvo]');

        const animarContador = (el) => {
            const alvo = parseInt(el.dataset.alvo);
            const duracao = 1800;
            const inicio = performance.now();

            const passo = (agora) => {
                const progresso = Math.min((agora - inicio) / duracao, 1);
                const easing = 1 - Math.pow(1 - progresso, 3);
                const valorAtual = Math.floor(easing * alvo);

                // Formatação personalizada para cada número
                if (alvo === 98) {
                    el.textContent = valorAtual + '%';
                } else if (alvo === 24) {
                    el.textContent = valorAtual + 'h';
                } else if (alvo === 12) {
                    el.textContent = valorAtual + '+';
                } else if (alvo === 35) {
                    el.textContent = valorAtual + '+';
                } else if (alvo === 1200) {
                    el.textContent = valorAtual.toLocaleString('pt-PT') + '+';
                } else if (alvo === 50000) {
                    el.textContent = (valorAtual / 1000) + 'k+';
                } else {
                    el.textContent = valorAtual.toLocaleString('pt-PT') + '+';
                }

                if (progresso < 1) {
                    requestAnimationFrame(passo);
                } else {
                    // Valor final fixo correto
                    if (alvo === 98) el.textContent = '98%';
                    else if (alvo === 24) el.textContent = '24h';
                    else if (alvo === 12) el.textContent = '12+';
                    else if (alvo === 35) el.textContent = '35+';
                    else if (alvo === 1200) el.textContent = '1200+';
                    else if (alvo === 50000) el.textContent = '50k+';
                }
            };

            requestAnimationFrame(passo);
        };

        const obsStats = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Encontra todos os números animados dentro do bloco visível
                    const numeros = entry.target.querySelectorAll('[data-alvo]') ?
                        entry.target.querySelectorAll('[data-alvo]') : [entry.target];
                    numeros.forEach(num => animarContador(num));
                    obsStats.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2
        });

        // Observa as seções que contêm números animados
        const secaoHero = document.querySelector('.hero-texto');
        const secaoStats = document.querySelector('.secao-stats');

        if (secaoHero) obsStats.observe(secaoHero);
        if (secaoStats) obsStats.observe(secaoStats);

        // ── Smooth scroll nos links internos ──
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', e => {
                const hrefAttr = link.getAttribute('href');
                if (hrefAttr === '#') return;
                const alvo = document.querySelector(hrefAttr);
                if (alvo) {
                    e.preventDefault();
                    alvo.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>


</body>

</html>