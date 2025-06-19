{
  description = "DevShell para GASS (PHP, Python, Node.js, Tailwind, OCR)";

  inputs = {
    nixpkgs.url = "github:NixOS/nixpkgs/nixos-unstable";
    flake-utils.url = "github:numtide/flake-utils";
  };

  outputs =
    {
      self,
      nixpkgs,
      flake-utils,
      ...
    }:
    flake-utils.lib.eachSystem [ "x86_64-linux" "aarch64-linux" "x86_64-darwin" "aarch64-darwin" ] (
      system:
      let
        pkgs = import nixpkgs {
          inherit system;
          config.allowUnfree = true;
        };

        phpWithXdebug = pkgs.php84.buildEnv {
          extensions = ({ enabled, all }: enabled ++ (with all; [ xdebug ]));
          extraConfig = ''
            xdebug.mode=debug
            xdebug.start_with_request=yes
            xdebug.client_host=127.0.0.1
            xdebug.client_port=9003
            xdebug.log_level=0
          '';
        };

        scripts = [
          (pkgs.writeShellScriptBin "tailwind:build" ''
            npx tailwindcss -i ./public/Assets/css/tailwind.css -o ./public/Assets/css/output.css --minify
          '')

          (pkgs.writeShellScriptBin "all-format" ''
            prettier . --check --write
            blade-formatter --write "app/Views/**/*.php"
            php-cs-fixer fix --show-progress=dots
          '')
        ];

        devPackages = with pkgs; [
          phpWithXdebug
          php84Packages.composer
          php84Packages.php-cs-fixer
          php84Extensions.mbstring
          php84Extensions.bcmath
          php84Extensions.curl
          php84Extensions.xml
          php84Extensions.zip
          php84Extensions.soap
          php84Extensions.gd
          php84Extensions.intl
          php84Extensions.ftp
          php84Extensions.mysqli
          php84Extensions.xdebug

          # Node + Tailwind
          nodejs_22
          pnpm
          nodePackages.prettier
          blade-formatter

          # Python + OCR
          python3
          python3Packages.pytesseract
          tesseract
          imagemagick

          # Otros
          curl
          zip
          unzip
        ];
      in
      {
        devShells.default = pkgs.mkShell {
          name = "gass-dev-env";
          packages = devPackages ++ scripts;
          shellHook = ''
            echo "[✔] Entorno de desarrollo GASS listo. Usa 'tailwind:build' o 'all-format'"
          '';
        };
      }
    );
}
