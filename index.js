import express from "express"
import bodyParser from "body-parser"

const app = express();
const port = 3000;

app.use(express.static("public"));
app.use(bodyParser.urlencoded({ extended: true }));

app.get("/", (req, res) => {
    res.render("login.ejs");
});

app.post("/login", (req, res) => {
    if (req.body["usuario"] === "admin" && req.body["senha"] === "admin") {
        res.render("index.ejs")
    } else {
        res.render("login.ejs", { mensagem: "Usuário ou senha inválidos" });
    }
});


app.listen(port, () => {
    console.log(`Server running on port ${port}`);
});