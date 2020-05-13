<div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?php echo $way; ?>">PACCE - UFC</a>
          </div>
          <div class="sidebar-user">
            <div class="sidebar-user-picture">
              <img alt="image" src="<?php echo URL_PAINEL.'imagensBolsistas/'.$user['foto']; ?>">
            </div>
            <div class="sidebar-user-details">
              <div class="user-name"><?php echo GetName($user['nome'], $user['nomeUsual']); ?></div>
              <div class="user-role">
                <?php echo $user['tipo']; ?>
              </div>
            </div>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="<?php echo ((isset($url[1]) && $url[1] == 'home') ? 'active' : '');  ?>">
              <a href="<?php echo $way.'/home'; ?>"><i class="ion ion-speedometer"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Menu</li>
            <?php 
              $menu = DBread('menu', "WHERE acessoSlug = '".$user['tipoSlug']."' AND status = true ORDER BY nome ASC");
              if ($menu == true) {
               for ($i=0; $i < count($menu); $i++) { 
             ?>
            <li class="<?php echo ((isset($url[1]) && $url[1] == $menu[$i]['nomeSlug']) ? 'active' : ''); ?>">
              <a href="<?php echo $way.'/'.$menu[$i]['nomeSlug']; ?>"><span><?php echo $menu[$i]['nome']; ?></span></a>
            </li>
          <?php } } ?>
          </ul>

        </aside>
      </div>