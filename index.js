import express from "express"
import bodyParser from "body-parser"
import bcrypt from "bcrypt"

const app = express();
const port = 3000;

const users = [];

app.use(express.json());

app.use(express.static("public"));
app.use(bodyParser.urlencoded({ extended: true }));

app.get("/", (req, res) => {
    res.render("login.ejs");
});

app.post("/signup", async (req, res) => {
    try {
        const salt = await bcrypt.genSalt();
        const hashedPassword = await bcrypt.hash(req.body.password, salt);
        console.log(salt);
        console.log(hashedPassword);
        const user = { email: req.body.email, password: hashedPassword}
        users.push(user);

        res.render("login.ejs");
        res.status(201);
        
    } catch (error) {
        res.render("login.ejs");
        res.status(500);
    }
});

app.post("/login", async (req, res) => {
    const user = users.find(user => user.email === req.body.email);
    if (user == null) {
        res.render("login.ejs", { mensagem: "Email ou senha inválido" });
    } try {
        if (await bcrypt.compare(req.body.password, user.password)) {
            res.render("index.ejs");
        } else {
            res.render("login.ejs", { mensagem: "Email ou senha inválido" });
        }
    } catch (error) {
        res.status(500);
    }
});


app.listen(port, () => {
    console.log(`Server running on port ${port}`);
});