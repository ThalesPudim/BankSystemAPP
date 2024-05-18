import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

public class ConnectionManager {
    private static final String URL = "jdbc:mysql://localhost:3306/hringbank?useSSL=false&serverTimezone=UTC&user=root";
    private static final String DRIVER_CLASS = "com.mysql.cj.jdbc.Driver";

    static {
        try {
            // Carrega a classe do driver MySQL
            Class.forName(DRIVER_CLASS);
        } catch (ClassNotFoundException e) {
            throw new RuntimeException("Não foi possível carregar o driver JDBC", e);
        }
    }

    public static Connection getConnection() throws SQLException {
        return DriverManager.getConnection(URL);
    }

    public static void main(String[] args) {
        Connection connection = null;
        Statement statement = null;
        ResultSet resultSet = null;

        try {
            // Testa a conexão com o banco de dados
            connection = getConnection();
            System.out.println("Conexão bem-sucedida!");

            // Cria um Statement para executar a consulta
            statement = connection.createStatement();

            // Executa a consulta SQL para selecionar todos os dados da tabela Users
            String sql = "SELECT * FROM Users WHERE UserID = 1";
            resultSet = statement.executeQuery(sql);

            // Processa os resultados da consulta
            while (resultSet.next()) {
                int userID = resultSet.getInt("UserID");
                String firstName = resultSet.getString("FirstName");
                String lastName = resultSet.getString("LastName");
                // Imprima os dados ou processe conforme necessário
                System.out.printf("UserID: %d, FirstName: %s, LastName: %s",
                        userID, firstName, lastName);
            }

        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Falha na conexão ou na execução da consulta.");
        } finally {
            // Fecha todos os recursos para evitar vazamento de memória
            try {
                if (resultSet != null) resultSet.close();
                if (statement != null) statement.close();
                if (connection != null) connection.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }
}