
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using LojaApi.Data;
using LojaApi.Models;

namespace LojaApi.Controllers
{
    [ApiController]
    [Route("api/fornecedor")]
    public class FornecedorController : ControllerBase
    {
        private readonly AppDbContext _context;

        public FornecedorController(AppDbContext context)
        {
            _context = context;
        }

        [HttpGet]
        public async Task<ActionResult<IEnumerable<Fornecedor>>> GetAll()
        {
            var fornecedores = await _context.Fornecedores.ToListAsync();
            return Ok(fornecedores);
        }

        [HttpPost]
        public async Task<ActionResult<Fornecedor>> Create([FromBody] Fornecedor fornecedor)
        {
            if (!ModelState.IsValid)
                return BadRequest(ModelState);

            _context.Fornecedores.Add(fornecedor);
            await _context.SaveChangesAsync();

            return CreatedAtAction(nameof(GetAll), new { codigo = fornecedor.Codigo }, fornecedor);
        }

        [HttpPut("{codigo}")]
        public async Task<IActionResult> Update(int codigo, [FromBody] Fornecedor fornecedor)
        {
            if (codigo != fornecedor.Codigo)
                return BadRequest("O código informado na URL não corresponde ao do corpo da requisição.");

            var existe = await _context.Fornecedores.AnyAsync(f => f.Codigo == codigo);
            if (!existe)
                return NotFound($"Fornecedor com código {codigo} não encontrado.");

            _context.Entry(fornecedor).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                return StatusCode(500, "Erro ao atualizar o fornecedor.");
            }

            return NoContent();
        }

        [HttpDelete("{codigo}")]
        public async Task<IActionResult> Delete(int codigo)
        {
            var fornecedor = await _context.Fornecedores.FindAsync(codigo);
            if (fornecedor == null)
                return NotFound($"Fornecedor com código {codigo} não encontrado.");

            _context.Fornecedores.Remove(fornecedor);
            await _context.SaveChangesAsync();

            return NoContent();
        }

        [HttpGet("nome/{nome}")]
        public async Task<ActionResult<IEnumerable<Fornecedor>>> GetByNome(string nome)
        {
            var fornecedores = await _context.Fornecedores
                .Where(f => f.Nome.Contains(nome))
                .ToListAsync();

            if (!fornecedores.Any())
                return NotFound($"Nenhum fornecedor encontrado com o nome contendo '{nome}'.");

            return Ok(fornecedores);
        }
    }
}