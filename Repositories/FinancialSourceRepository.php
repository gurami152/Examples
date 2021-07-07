<?php


namespace App\Repositories;


use App\FinancialSource;

class FinancialSourceRepository
{
    /**
     * @var FinancialSource $financialSource
     */
    protected $financialSource;

    /**
     * FinancialSourceRepository constructor.
     * @param FinancialSource $financialSource
     */
    public function __construct(FinancialSource $financialSource)
    {
        $this->financialSource = $financialSource;
    }

    public function all()
    {
        return FinancialSource::all();
    }

    public function paginated($size)
    {
        return FinancialSource::paginate($size);
    }

    public function delete($id)
    {
        $this->financialSource->findOrFail($id)->delete();
    }
}
